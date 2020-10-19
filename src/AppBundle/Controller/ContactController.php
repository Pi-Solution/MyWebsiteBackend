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

        $data = json_decode($request->getContent(), true);

        # Validate reCaptcha
        $googleReCaptchaValidator = $this->get('validation.google_recaptcha_validator');

        $googleReCaptchaValidatorResponse = $googleReCaptchaValidator->validate($data['reQapToken']);

        if ($googleReCaptchaValidatorResponse['success']){

            # Save message
            $contactMessageFactory = $this->get('factory.contact_message');

            $response = $contactMessageFactory->create($data);

            if ($response['saved']){

                # Send notification
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
