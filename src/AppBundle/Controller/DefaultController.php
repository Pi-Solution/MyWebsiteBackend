<?php

namespace AppBundle\Controller;

use Pimcore\Controller\FrontendController;

class DefaultController extends FrontendController
{
    public function defaultAction(\Pimcore\Config\Config $websiteConfig)
    {

//        $redirectWebsite = $websiteConfig->get('redirect_website');
//
//        return $this->redirect($redirectWebsite, 303);

    }
}
