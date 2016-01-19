<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use AppForwardBundle\Manager\MailAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;

class DefaultController extends Controller
{
    public function createAction(Request $request){

        $newAlias = new Alias();
        $userId = "1";

        $url_value = $request->request->get('url');
        $site_value = $request->request->get('site');
        // set user id in newAlias
        $newAlias->setUserId($userId);
        $newAlias->setSite($site_value);
        $newAlias->setUrl($url_value);
        // set random Address in newAlias
        $aliasAddress = MailAddress::generateMailAddress($newAlias->getUserId(), $newAlias->getSite());
        $newAlias->setAddress($aliasAddress);

        // set created & modified at now
        $now = new DateTime('now');
        $newAlias->setCreated($now);
        $newAlias->setModified($now);

        // create in db
        $entityManager = $this->getEntityManager();
        $entityManager->persist($newAlias);
        $entityManager->flush();

        exit($aliasAddress); // TODO : make it better
    }

    private function getEntityManager() {
            return $this->getDoctrine()->getEntityManager();
    }
}