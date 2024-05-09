<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

class CardController extends Controller
{
    
    public function make_payment(Request $request, $details)
    {

        $res = $this->generateToken();
        $token = json_decode($res);

        $order_id = $details->order_id;
        $first_name = $request->user_name;
        $last_name = '';
        $email = $request->user_email;
        $phone = $request->user_number;

        $currency = 'KES';
        $amount = $details->amount;
        //$amount=1;
        $description = $request->description;
        $callback_url = url('/').'/pesapal/card/payment/callback';
        $notification_id = env('PESAPAL_NOTIFICATION_ID');

        // dd($callback_url);

        if ($token->result_code == 0) {
            $data = '
            {
                "id": "'.$order_id.'",
                "currency": "'.$currency.'",
                "amount": "'.$amount.'",
                "description": "'.$description.'}",
                "callback_url": "'.$callback_url.'",
                "notification_id": "'.$notification_id.'",
                "billing_address": {
                    "email_address": "'.$email.'",
                    "phone_number": "'.$phone.'",
                    "country_code": "KE",
                    "first_name": "'.$first_name.'",
                    "middle_name": "",
                    "last_name": "'.$last_name.'",
                    "line_1": "",
                    "line_2": "",
                    "city": "",
                    "state": "",
                    "postal_code": "",
                    "zip_code": ""
                }
            }';

            //dd($data);

            $post_string = $data;

            /*
            Headers
            */
            $headers = [
                'Accept: application/json',
                'Content-Type: application/json',
                'Authorization: Bearer '.$token->data,

            ];

            // dd($headers);

            $url = 'https://pay.pesapal.com/v3/api/Transactions/SubmitOrderRequest';
            $res = $this->submitRequest($url, $post_string, $headers, 'POST');

            // dd($res);
            $result = json_decode($res, true);
            dd($result);

            $payment = [
                'order_id'=>$order_id,
                'transaction_code'=>$result['OrderTrackingId'],
                'phone'=>$phone,
                'status'=>'success'
            ];

            if (isset($result['redirect_url'])) {
                $response['result_code'] = 0;
                $response['message'] = 'Success';
                $response['data'] = $result['redirect_url'];

                return $response;
            // return redirect($result['redirect_url']);

            } else {

                // dd($result['error']['message']);

                if (isset($result['error']['message'])) {
                    $response['result_code'] = 1;
                    $response['message'] = $result['error']['message'];
                    $response['data'] = $result['error'];

                    return $response;
                } else {
                    $response['result_code'] = 1;
                    $response['message'] = 'Bad Request';
                    $response['data'] = $result;

                    return $response;
                }

            }

        } else {
            return $token;
        }

    }

    public function callback(Request $request)
    {

        $data = $request->all();
        $res = $this->generateToken();
        $token = json_decode($res);

        $trackingId = $data['OrderTrackingId'];

        $credentials = [
            'orderTrackingId' => $trackingId,

        ];

        $post_string = json_encode($credentials);

        /*
        Headers
        */
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$token->data,

        ];

        $url = "https://pay.pesapal.com/v3/api/Transactions/GetTransactionStatus?orderTrackingId={$trackingId}";
        $res = $this->submitRequest($url, $post_string, $headers, 'GET');

        //dd($res);
        $result = json_decode($res, true);
        //dd($result);

        $transactionId = $result['merchant_reference'];
        $payment = Payment::where('transaction_id', $transactionId)->first();

        // dd($result);

        if (! $payment) {

            $response['result_code'] = 0;
            $response['message'] = "Payment not found for transaction ID {$transactionId}";
            $response['data'] = $result;

            return $response;

        }

        //Payment Found Get PArams
        $params = json_decode($payment->transaction_data);
        //dd(urldecode($params->redirect_url));

        if (isset($result['payment_status_description']) && $result['payment_status_description'] == 'Completed') {

            $response['result_code'] = 0;
            $response['message'] = 'Success';
            $response['data'] = $result;

            $transactionRefNumber = $result['confirmation_code'];
            $transactionType = $result['payment_method'];
            $transactionType = 'card';

            //Update make_payment

            // redirect to a success page

            $payment->transaction_ref_number = $transactionRefNumber;
            $payment->transaction_status = 'complete';
            $payment->transaction_ref_type = $transactionType;

            $payment->save();

            // $url=env('SITE_PUBLIC_URL')."?pay=success";
            //SHow Success Page

            // $data_array=[];
            // $redirect_data= json_decode($params->redirect_data);

            // foreach ($redirect_data as $index => $data) {

            //     $data_array[$data->name]=$data->value;
            // }

            //  unset($data_array['_token']);

            // //dd($data_array);

            // $query=http_build_query($data_array);
            //dd($query);

            $redirect_url = env('SITE_PUBLIC_URL').'/ticket/purchase/success';

            return redirect($redirect_url);

        } else {

            if (isset($result['error'])) {
                $response['result_code'] = 1;
                $response['message'] = $result['error']['message'];
                $response['data'] = $result['error'];

                $redirect_url = urldecode($params->redirect_url);
                $redirect_url += '&pay=error';

                return redirect($redirect_url);
            } else {
                $response['result_code'] = 1;
                $response['message'] = 'Failed Request';
                $response['data'] = $result;

                $redirect_url = urldecode($params->redirect_url);
                $redirect_url += '&pay=failed';

                return redirect($redirect_url);

            }

        }

    }

    public function generateToken()
    {

        $credentials = [
            'consumer_key' => env('PESAPAL_KEY_TEST'),
            'consumer_secret' => env('PESAPAL_SECRET_TEST'),

        ];

        //  dd($credentials);

        $post_string = json_encode($credentials);

        /*
        Headers
        */
        $headers = [
            'Accept: application/json',
            'Content-Type: application/json',

        ];

        $url = 'https://pay.pesapal.com/v3/api/Auth/RequestToken';
        $res = $this->submitRequest($url, $post_string, $headers, 'POST');

        //dd($res);
        $result = json_decode($res, true);
        //dd($result);

        if (isset($result['token'])) {

            $response['result_code'] = 0;
            $response['message'] = 'Success';
            $response['data'] = $result['token'];

        } else {

            if (isset($result['error'])) {
                $response['result_code'] = 1;
                $response['message'] = $result['error']['message'];
                $response['data'] = $result['error'];

            } else {
                $response['result_code'] = 1;
                $response['message'] = 'Bad Credentials for Token';
                $response['data'] = $result;

            }

        }

        return json_encode($response);

    }

    public static function generateRandomString()
    {
        $length = 10;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    public function submitRequest($url, $post_string, $headers, $type)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        if ($type == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
        }

        $data = curl_exec($ch);
        if ($data === false) {
            $err = 'Curl error: '.curl_error($ch);
            curl_close($ch);
            echo "Error \n".$err;
            $body = '';
        } else {
            curl_close($ch);
            $body = $data;

        }

        return $body;
    }
}
