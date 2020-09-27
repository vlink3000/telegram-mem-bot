<?php

class CallTelegramApi
{
    public function sendPostRequest($method, $params = [])
    {
        $config = include($_SERVER["DOCUMENT_ROOT"].'/core/Config/config.php');
        $baseUrl = $config['endpoint'];

        if(!empty($params)) {
            $url = $baseUrl . $method . '?' . http_build_query($params);
        } else {
            $url = $baseUrl . $method;
        }

        $ch = curl_init($url);
        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        return $params;
    }
}