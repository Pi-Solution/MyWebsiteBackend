<?php


namespace AppBundle\Services;


use GuzzleHttp\Client;

class WirePusherService
{

    private $url;
    private $id;
    private $type;

    public function __construct($config)
    {
        $this->url = $config['url'];
        $this->id = $config['id'];
        $this->type = $config['type'];
    }

    public function pushNotification($data){

        $body =
            "?id=PMpHmpXLa&" .
            "title=Website Contact Form&".
            "message=".
                $data['full_name'] . "%0D%0A" .
                $data['email'] . "%0D%0A%0D%0A" .
                $data['message'] . "%0D%0A" .
            "&type=Default";

        $client = new Client();

        try {

            $response = $client->request('GET', $this->url . $body);

            return [
              'sent' => true
            ];

        } catch (\Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);

        }
    }
}
