<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Order;
// use SmoDav\Mpesa\C2B\STK;
use GuzzleHttp\Client;
// use SmoDav\Mpesa\Engine\Core;
// use SmoDav\Mpesa\Native\NativeCache;
// use SmoDav\Mpesa\Native\NativeConfig;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Mail\PaymentReceived;
use App\Enums\PaymentStatusEnum;
use App\Mail\PaymentFailed;
use App\Models\Customer;
use Illuminate\Support\Facades\Mail;
use SmoDav\Mpesa\Laravel\Facades\STK;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function initiateSTK($data){
        $order = Order::find($data['order_id']);
        $description = 'Pay ' . $data['amount'] . ' to EnvyAfrica.';
        $phone = '254'.substr($data['phone'], -9);

        $expressResponse = STK::push(1, $phone, $data['order_number'], $description);
        $responseData = (array) $expressResponse;
        $tdate = Carbon::now()->timezone(env('TIMEZONE'))->format('d/m/Y');
        $ttime = Carbon::now()->timezone(env('TIMEZONE'))->format('g:i A');
        $tdatetime = $tdate.' '.$ttime;

        if ($responseData['ResponseCode']=="0") {
            $newPayment = [
                'status' => PaymentStatusEnum::PENDING,
                'phone' => $phone,
                'order_id' => $order->id,
                'amount' => $order->amount,
                'checkout_request_id' => $responseData['CheckoutRequestID'],
                'merchant_request_id' => $responseData['MerchantRequestID'],
                'transaction_data' => json_encode($responseData),
                'transaction_date_time' => $tdatetime,
                'transaction_date' => $tdate,
                'transaction_time' => $ttime,
            ];
            $payment = Payment::create($newPayment);

            if($order){
                $order->payment_id=$payment->id;
                $order->save();
            }
        }else
        {
            $payment = Payment::create([
                'status' => PaymentStatusEnum::FAILED,
                'phone' => $phone,
                'order_id' => $order->id,
                'amount' => $order->amount,
            ]);
            if($order){
                $order->payment_id=$payment->id;
                $order->save();
            }
            return redirect('/')->with('error', 'An error occurred. Could not pay using mpesa.');
        }
    }

    /**
     * Handles the callback from an STK payment.
     *
     * @param  Request  $request  The request data.
     * @return array The response data.
     */
    public static function stkCallback(Request $request)
    {
        $data = $request->all();
        $data = (object) $data;

        $req_dump = print_r($data, true);
        Storage::disk('local')->append('all_payments_log.txt', $req_dump);

        sleep(5);

        $data = json_encode($data->Body['stkCallback'], true);
        $data = (object) json_decode($data, true);

        $resultcode = $data->ResultCode;
        $transactionid = $data->CheckoutRequestID;
        $transactiondesc = $data->ResultDesc;

        //find payment
        $payment = Payment::where(['checkout_request_id' => $transactionid])->first();
        if(!$payment){
            return;
        }
        $order = Order::find($payment->order_id);
        $customer = [];
        if($order){
            $customer = Customer::find($order->customer_id);
        }

        $payment->result_description = $transactiondesc;

        if ($resultcode == 0) {
            $metadata = $data->CallbackMetadata;
            $items = $metadata['Item'];

            $result = [];
            foreach ($items as $item) {
                if (array_key_exists('Value', $item)) {
                    $result[$item['Name']] = $item['Value'];
                }
            }

            if (array_key_exists('MpesaReceiptNumber', $result)) {
                $payment->transaction_code = $result['MpesaReceiptNumber'];
                $payment->amount = $result['Amount'];
                $payment->phone = $result['PhoneNumber'];
                $payment->result_code = $resultcode;
                $payment->status = PaymentStatusEnum::SUCCESS;
                $payment->save();

                $newMail = (new PaymentReceived($payment, $customer, $order))
                    ->to($customer['email']);
                Mail::send($newMail);
            } else {
                Storage::disk('local')->append('failure_log.txt', $req_dump);

                $payment->result_code = $resultcode;
                $payment->status = PaymentStatusEnum::FAILED;
                $payment->save();

                $newMail = (new PaymentFailed($payment, $customer, $order))
                    ->to($customer['email']);
                Mail::send($newMail);
            }
        } else {
            Storage::disk('local')->append('failure_log.txt', $req_dump);

            $payment->status = PaymentStatusEnum::FAILED;
            $payment->save();

            $newMail = (new PaymentFailed($payment, $customer, $order))
                    ->to($customer['email']);
                Mail::send($newMail);
        }
        return;
    }
}
