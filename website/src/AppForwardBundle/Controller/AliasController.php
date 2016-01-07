<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use AppForwardBundle\Manager\MailAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

class AliasController extends Controller
{
    public function addAction(Request $request)
    {
        // 1) build the form
        $newAlias = new Alias();
        $form = $this->createForm(AliasType::class, $newAlias);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // set user id in newAlias
            $userId = $this->getUser()->getId();
            $newAlias->setUserId($userId);

            // set random Address in newAlias
            $aliasAddress = MailAddress::generateMailAddress($newAlias->getUserId(), $newAlias->getSite());
            $newAlias->setAddress($aliasAddress);

            // set created & modified at now
            $now = new DateTime('now');
            $newAlias->setCreated($now);
            $newAlias->setModified($now);
            
            exit("TODO: save it !");

            //return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'AppForwardBundle:Form:alias.html.twig',
            array('form' => $form->createView())
        );
    }
}
