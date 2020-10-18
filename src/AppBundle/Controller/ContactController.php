<?php


namespace AppBundle\Controller;


use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends FrontendController
{

    /**
     * @param Request $request
     * @return Response
     * @Route("/contact/form", methods={"POST"})
     */
    public function formAction(Request $request){

//        if ($request->server->get('HTTPS_ORIGIN') != $this->container->getParameter('corsAllowOrigin')){
//
//            return new Response('', 403);
//
//        }

        $data = json_decode($request->getContent(), true);

        $googleReCaptchaValidator = $this->get('validation.google_recaptcha_validatior');

        if ($googleReCaptchaValidator->validate($data['reQapToken'])){

            $contactMessageFactory = $this->get('factory.contact_message');

            $response = $contactMessageFactory->create($data);

            if ($response['saved']){

                $pushNotification = $this->get('custom_services.wire_pusher_services');

                $pushNotification->pushNotification($data);

            }
        } else {
            $response = [
                'saved' => false,
                'errors' => [
                    'reCaptcha Error'
                ]
            ];
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
