<?php

namespace App\Services;

class ExpoNotification
{
    private $token;
    private $message;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($token, $message)
    {
        $this->token = $token;
        $this->message = $message;
    }

    public function send()
    {
        $payload = array(
            'to' => $this->token,
            'sound' => 'default',
            'title' => 'Miss Laundry',
            'body' => $this->message
        );

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://exp.host/--/api/v2/push/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                "Accept: application/json",
                "Accept-Encoding: gzip, deflate",
                "Content-Type: application/json",
                "cache-control: no-cache",
                "host: exp.host"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }
}
