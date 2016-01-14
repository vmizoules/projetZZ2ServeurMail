<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class DefaultController extends Controller
{
    public function homepageAction()
    {
        // helloworld
        return $this->render('AppForwardBundle:Default:homepage.html.twig');
    }
}
