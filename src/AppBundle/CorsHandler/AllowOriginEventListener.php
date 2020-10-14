<?php


namespace AppBundle\CorsHandler;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AllowOriginEventListener
{
    private $origin;

    public function __construct($origin)
    {
        $this->origin = $origin;
    }

    public function onKernelResponse(ResponseEvent $event){

        if ($event->getRequest()->getMethod() === 'OPTIONS') {

            $response = $event->setResponse(
                new Response('', 204, [
                    'Access-Control-Allow-Origin' =>  $this->origin,
                    'Access-Control-Allow-Methods' => 'GET, POST', 'OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                ])
            );

            return;
        }

    }
}
