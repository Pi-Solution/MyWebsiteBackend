<?php


namespace AppBundle\Controller;


use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\ContactMessage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Pimcore\Config\Config;

class ContactController extends FrontendController
{

    /**
     * @param \Pimcore\Config\Config $websiteConfig
     * @param Request $request
     * @return Response
     * @Route("/contact/form")
     */
    public function formAction(Config $websiteConfig, Request $request){

        if ($request->server->get('HTTP_ORIGIN') != $this->container->getParameter('corsAllowOrigin')){

            return new Response('', 403);

        }

        $contactMessageFactory = $this->get('factory.contact_message');

        $response = $contactMessageFactory->create(json_decode($request->getContent(), true));

        if ($response['saved']){

            $pushNotification = $this->get('custom_services.wire_pusher_services');

            $pushNotification->pushNotification(json_decode($request->getContent(),true));

        }

        return new Response(

            json_encode($response),

            Response::HTTP_OK,

            [
                'Access-Control-Allow-Origin' => $this->container->getParameter('corsAllowOrigin'),
                'Access-Control-Allow-Methods' => 'GET, POST',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                'Content-Type' => 'application/json'
            ]
        );

    }

//    /**
//     * @Route("/contact/test")
//     */
//    public function test(){
//
//        return $this->render('Default/test.html.twig');
//
//    }
}
