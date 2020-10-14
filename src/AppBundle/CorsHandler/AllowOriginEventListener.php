<?php


namespace AppBundle\CorsHandler;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class AllowOriginEventListener
{

    public function onKernelResponse(ResponseEvent $event){
           // echo 'petar'; die;
        if ($event->getRequest()->getMethod() === 'OPTIONS') {

            $response = $event->setResponse(
                new Response('', 204, [
//                    'Access-Control-Allow-Origin' => 'http://my-website.loc/contact',
//                    'Access-Control-Allow-Credentials' => 'true',
//                    'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS',
//                    'Access-Control-Allow-Headers' => 'DNT, X-User-Token, Keep-Alive, User-Agent, X-Requested-With, If-Modified-Since, Cache-Control, Content-Type',
//                    'Access-Control-Max-Age' => 1728000,
//                    'Content-Type' => 'text/plain charset=UTF-8',
//                    'Content-Length' => 0
                    'Access-Control-Allow-Origin' =>  'http://my-website.loc',
                    'Access-Control-Allow-Methods' => 'GET, POST', 'OPTIONS',
                    'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                ])
            );

            return;
        }

    }
}
