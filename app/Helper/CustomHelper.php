<?php
namespace App\Helper;

class CustomHelper
{

    public function __construct()
    {
        
    }

    public static function get_usd()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://blockchain.info/ticker",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
                "Accept: */*",
                "Accept-Encoding: gzip, deflate",
                "Cache-Control: no-cache",
                "Connection: keep-alive",
                "Cookie: __cfduid=d6343d007e7fbe934cf8cfea37d3764ef1574153279",
                "Host: blockchain.info",
                "Postman-Token: 956d6fa5-b000-400f-a088-10b6209603ad,e4a29032-5479-4e8f-8c3a-a075eb973242",
                "User-Agent: PostmanRuntime/7.19.0",
                "cache-control: no-cache"
            ),
        ));

        $response = json_decode(curl_exec($curl));
        $err = curl_error($curl);

        curl_close($curl);
        $usd = $response->USD->last;

        if ($err) {
            return "cURL Error #:" . $err;
        } else {
            return $usd;
        }
    }

    public static function datalog($content){
        $filename = storage_path() . '\\datalogs\\datalogs.log';
        
        if ($handle = fopen($filename, 'a')) {
            if (fwrite($handle, $content . " \n") === FALSE) {
                return FALSE;
            }
            fclose($handle);
            return TRUE;
        }
        return FALSE;
    }

    
}
