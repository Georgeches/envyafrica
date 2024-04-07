<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Models\Payment;
use GuzzleHttp\Client;
use SmoDav\Mpesa\C2B\STK;
use Illuminate\Http\Request;
use SmoDav\Mpesa\Engine\Core;
use SmoDav\Mpesa\Native\NativeCache;
use SmoDav\Mpesa\Native\NativeConfig;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function initiateSTK($data){
        $config = new NativeConfig();
        $cache = new NativeCache($config->get('cache_location'));
        $core = new Core(new Client, $config, $cache);
        $stk = new STK($core);
        $description = 'Pay ' . $data['amount'] . ' to EnvyAfrica.';
        $response = $stk->push($data['amount'], $data['phone'], $data['order_number'], $description, 'staging');
        dd($response);

        Payment::create([
            'initiator_id' => $response->CheckoutRequestID,
        ]);
    }

    /**
     * Handles the callback from an STK payment.
     *
     * @param  Request  $request  The request data.
     * @return array The response data.
     */
    public static function stkCallback(Request $request): void
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
        $payment = Payment::where(['initiator_id' => $transactionid])->first();
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
                $payment->transaction_ref = $result['MpesaReceiptNumber'];
                $payment->amount = $result['Amount'];
                $payment->notification_phone = $result['PhoneNumber'];
                $payment->source_account = $result['PhoneNumber'];
                $payment->result_code = $resultcode;
                $payment->status = PaymentStatusEnum::SUCCESS;
                $payment->save();

                // $transaction = Transaction::where('transaction_id', $transactionid)->first();

            } else {
                Storage::disk('local')->append('failure_log.txt', $req_dump);

                $payment->status = PaymentStatusEnum::FAILED;
                $payment->save();
            }
        } else {
            Storage::disk('local')->append('failure_log.txt', $req_dump);

            $payment->status = PaymentStatusEnum::FAILED;
            $payment->save();
        }
        return;
    }
}
