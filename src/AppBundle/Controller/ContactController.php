<?php


namespace AppBundle\Controller;


use Pimcore\Controller\FrontendController;
use Pimcore\Model\DataObject\ContactMessage;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
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

        if ($request->server->get('HTTP_ORIGIN') != $websiteConfig->get('form_origin')){

            return new Response('', 403);

        }

        $data = json_decode($request->getContent(), true);

        $contactMessage = new ContactMessage();

        $contactMessage->setFullName($data['full_name']);
        $contactMessage->setEmail($data['email']);
        $contactMessage->setMessage($data['message']);
        $contactMessage->setParentId(2);
        $contactMessage->setKey($data['email'] . date('c'));
        $contactMessage->setPublished(true);

        $contactMessageSaved = $contactMessage->save();

        if ($contactMessageSaved){

            $response = [
              'saved' => true
            ];

        } else {

            $response = [
                'saved' => false,
                'errors' => [
                    'Server error please try again in few minutes.'
                ]
            ];

        }

        $response = new Response(
            json_encode($response)
            ,
            Response::HTTP_OK,
            [
                'Access-Control-Allow-Origin' =>  'http://my-website.loc',
                'Access-Control-Allow-Methods' => 'GET, POST',
                'Access-Control-Allow-Headers' => 'Content-Type, Authorization',
                'Content-Type' => 'application/json'
            ]
        );

        return $response;

    }

    /**
     * @Route("/contact/test")
     */
    public function test(){

        return $this->render('Default/test.html.twig');

    }
}
