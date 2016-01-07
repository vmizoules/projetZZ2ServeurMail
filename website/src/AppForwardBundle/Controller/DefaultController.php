<?php

namespace AppForwardBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('AppForwardBundle:Default:index.html.twig');
    }
}
