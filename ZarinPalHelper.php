<?php 

namespace App\Helpers;

class ZarinPalHelper
{
    public static function new_url($totalPrice, $buyDescription="")
    {
        $data = array('MerchantID' => env('DEXSHARP_ZARRINPAL_APIKEY'), 'Amount' => $totalPrice,
                      'CallbackURL' => env('DEXSHARP_ZARRINPAL_CALLBACK_URL') , 'Description' => $buyDescription);
    
        $jsonData = json_encode($data);
        $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentRequest.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($jsonData)
        ));
    
        $result = curl_exec($ch);
        $err = curl_error($ch);
        $result = json_decode($result, true);
        $result['error']=$err;
        curl_close($ch);
        return $result;
    }
    
    public static function verify_pay($Authority, $Amount)
    {
        $data = array('MerchantID' => env('DEXSHARP_ZARRINPAL_APIKEY') , 'Authority' => $Authority, 'Amount' => $Amount);
        $jsonData = json_encode($data);
        $ch = curl_init('https://www.zarinpal.com/pg/rest/WebGate/PaymentVerification.json');
        curl_setopt($ch, CURLOPT_USERAGENT, 'ZarinPal Rest Api v1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
             'Content-Type: application/json',
             'Content-Length: ' . strlen($jsonData)
             ));
        $result = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        $result = json_decode($result, true);
        if ($err) {
            return [ 'status'=>0 , 'error'=> "cURL Error #:" . $err ] ;
        } else {
            if ($result['Status'] == 100) {
                return [ 'status'=>1 , 'tracking_code'=> $result['RefID'] ];
            } else {
                return [ 'status'=>0 , 'error'=> 'Transation failed. Status:' . $result['Status'] ];
            }
        }
    }
}
