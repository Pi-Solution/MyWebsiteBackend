<?php


namespace AppBundle\Factory;


use Pimcore\Model\DataObject\ContactMessage;

class ContactMessageFactory
{
    public function create($data){

        $contactMessage = new ContactMessage();

        $contactMessage->setFullName($data['full_name']);
        $contactMessage->setEmail($data['email']);
        $contactMessage->setMessage($data['message']);
        $contactMessage->setParentId(2);
        $contactMessage->setKey($data['email'] . date('c'));
        $contactMessage->setPublished(true);
        $savedContactMessage = $contactMessage->save();

        if ($savedContactMessage){
            $response = [
                'saved' => true,
                'message' => 'Thank you for contacting me, I will reply as soon as possible'
            ];
        }else{
            $response = [
                'saved' => false,
                'errors' => [
                    'Please check you fields'
                ]
            ];
        }

        return $response;

    }
}
