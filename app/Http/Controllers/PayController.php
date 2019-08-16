<?php

namespace App\Http\Controllers;

use Yansongda\Pay\Pay;
use Illuminate\Http\Request;

class PayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['return','notify']]);
    }
    protected $config = [
        'alipay' => [
            'app_id' => '2016101000654781',
            'notify_url' => 'http://localhost//blog/public/api/pay/notify',
            'return_url' => 'http://localhost/blog/public/api/pay/return',
            'ali_public_key' => 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA25jWAOkBYLig2ZTccXgdDwBoAShSftgsHQrfdT+Z0if72mcnQIR8xsxm0YuyTBoGJAZgItYHwiPjO8I+9UFqVNh6vSMCizNk1pLMRJI6Jr1SJwnj3+1/50dX1amEQENzehtiYMKZz2vBUyc83OvO7THBIgBHlp3l0Lqmw/2Mxh493Say3nGeB6iUo/QFBfi8N8GbnRC7Ipr8xtrpb/v3SbBzOylqJp/HmxQ2pA2+93WApOUsoLkfCnMf6W/t7bS+ihfJapIL+cuuTw144/62I9jU9ypJW1154IW+vopbVJFEeRIZJAMqnRQxnkPZ6f4jwxaY8ebk/FANW+fg1/kd0wIDAQAB',
            'private_key' => 'MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDJxLXiuITSIyzRTQeuyi8Gfdms4Qi4HAxVnzlVs+niR2jSSFprhui6pVwf16ZR3hKfxSme4Jd2ibidoPoTrYHXmcLOYpgxy7Ke1AOlvjDGeWEPMYXluJzO/qPnJ73nWqVV5+LFPD20BN9zJIM9q59MmjID6jatWh9X1rBP7cNBPnfSYhx/04LDkYeDTtswGyxKdV1R52oCF1ivjiVTJXcFVcG5s7KQYrvanIwp1mO0/OQ3kg2V4oAqt5DbMjoflfvRfmnMbZPfv9gBjNN5895MQBqDG5lVH8KZb7/SZkR6v8qd3X02TKT9qyqpHGycTRzBmjBa0CP3h+Jn2leQk88xAgMBAAECggEAdzdejPafrBYSjhyolHNsM7a6njZc04PnGdQ5qVTjtcqhudX8bxpIerfn5fyiji7b7EEv5Wsos2aOibyq5mOXm4+DljSVXp7QDJ6TBSSKZ0siuTp2thRNutSkfZly0Lczh726tPVyM+LJMJx7Wz4Dotxc/wktg2IDsP/uL1v6CZrVCWkbLVvsh9PJzauGnUknfemcaVNX4RVO0z3UBZ0NfO6rO1Qi/FH7wI7y8M0vpg31uRB4jwlHI39v3K7OjSyayZsd8Jm2hng9alXImadWZgV98BqK2Fiq1AZ+3KmTIooV/E/3LJcwhWlpYAjBFVSKNwLOzCt8twK4+3U7u1mmAQKBgQD1mxXJBFlfsJ9aQzaH5ZFevQI078j12UmX49FxkCrtPdzhYxRInI/6eVSvQh0k2FDxf2ORObsnHKWIcOGmRa84jvE+werRP7XpkAc3XCJ0vPy/mRjCSrwl5uCw0xn8PSsOfOpfi8DP4C908JDu6CE9Ma/wVdXeYPAD1KxyDb4EIQKBgQDSTq/nktVS9aTIll39pWpZV8mFwG1lIS/Bi76O44tTiRo31fMCNWzMlrn6zVF2UhEa+wtnRHDf+ZQ3J5kgMNsKpRA98aYdiFioGsbjScngGaIeSWl/MY5l0ISbdGql6yIOVadB5CBKJ0Ltyv0nd/XZyX2XjMzIKqUeN+fUzsRpEQKBgHZri0p79VfFAmB0DePiVYA3Y8wAXYXkea5pov+9gmUXMdveeNY13tnnDGTgXMr6HbUDNg+8pTdLgajSvIn+CWkcysb2mvC/ZkeyMTiJDPf6c2cyOxTbEfK4alf3wQy0tYDry9m7uYDBWEBrCYaXmAc4YNthl5f8Z12BepAXfinhAoGAMv9JwInmmNtgPhPYbu1xwIB9KaXj4SYPAov0hYm/+12/sdJ7vwldfK8AIkUvf9WeuEAwH7aE+Ir42fcMNrYiJ46nRZ4XfgnWFc2IdQ0rmuAcY+PBZUqLET1jKp8sTVebRoaWrG+5NMIYhLk4ch2wzEMD5YALGG7e41kDKqOJFUECgYAwRN+v78TzQn+iBdxIuHqGtJa6A1yLvkeWH8GHs6KiPwEzh/iJk53tnDpboJDOGwpycpGLUyS8m5x/pTuOTeZYM5vCdi8lwlTT3yHvQXxv7atJtiaLPLDjqDIb5UGgBtNFv4n9zlEBC2RSIaXIlSWzGmW+kH6WoobXj4EILc2OUA==',
        ],
    ];

    public function index(Request $request)
    {
        $config_biz = [
            'out_trade_no' =>  $request->input('oid'),
            'total_amount' => $request->input('price'),
            'subject'      => 'test subject',
        ];
        $pay = new Pay($this->config);

        return $pay->driver('alipay')->gateway()->pay($config_biz);
    }

    public function return(Request $request)
    {
        $pay = new Pay($this->config);
        return $pay->driver('alipay')->gateway()->verify($request->all());

    }

    public function notify(Request $request)
    {
        $pay = new Pay($this->config);

        if ($pay->driver('alipay')->gateway()->verify($request->all())) {
            // 请自行对 trade_status 进行判断及其它逻辑进行判断，在支付宝的业务通知中，只有交易通知状态为 TRADE_SUCCESS 或 TRADE_FINISHED 时，支付宝才会认定为买家付款成功。 
            // 1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号； 
            // 2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额）； 
            // 3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）； 
            // 4、验证app_id是否为该商户本身。 
            // 5、其它业务逻辑情况
            file_put_contents(storage_path('notify.txt'), "收到来自支付宝的异步通知\r\n", FILE_APPEND);
           file_put_contents(storage_path('notify.txt'), '订单号：' . $request->out_trade_no . "\r\n", FILE_APPEND);
            file_put_contents(storage_path('notify.txt'), '订单金额：' . $request->total_amount . "\r\n\r\n", FILE_APPEND);
        } else {
            file_put_contents(storage_path('notify.txt'), "收到异步通知\r\n", FILE_APPEND);
        }

        echo "success";
    }
}