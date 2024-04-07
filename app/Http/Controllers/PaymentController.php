<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use SmoDav\Mpesa\C2B\STK;
use Illuminate\Http\Request;
use SmoDav\Mpesa\Engine\Core;
use SmoDav\Mpesa\Native\NativeCache;
use SmoDav\Mpesa\Native\NativeConfig;

class PaymentController extends Controller
{
    public function initiateSTK(){
        $config = new NativeConfig();
        $cache = new NativeCache($config->get('cache_location'));
        $core = new Core(new Client, $config, $cache);
        $stk = new STK($core);
        $response = $stk->push(10, 254792602154, 'PE37382', 'Test Payment', 'staging');
    }
}
