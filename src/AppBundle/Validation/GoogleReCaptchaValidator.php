<?php


namespace AppBundle\Validation;


use GuzzleHttp\Client;

class GoogleReCaptchaValidator
{
    private $secretKey;
    private $googleApiUrl;

    public function __construct($parametars)
    {
        $this->secretKey = $parametars['secretKey'];
        $this->googleApiUrl = $parametars['url'];
    }

    public function validate($reCaptchaResponse)
    {
        try {
            //make request to get access token
            $headers = [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ];

            $client = new Client([
                'headers' => $headers
            ]);

            $response = $client->request('POST', $this->googleApiUrl,
                [
                    'debug' => false,
                    'form_params' => [
                        'secret' => $this->secretKey,
                        'response' => $reCaptchaResponse
                    ]
                ]
            );

            if($response->getStatusCode() == 200){

                return json_decode($response->getBody()->getContents(), true);

            } else {

                return [];

            }

        } catch (\Exception $e){
            return null;
        }
    }
}
