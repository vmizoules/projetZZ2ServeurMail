<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use AppForwardBundle\Manager\MailAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use \DateTime;
use \Exception;

class DefaultController extends Controller
{
    public function createAction(Request $request){

        // test it with : curl --data "site=mysite&url=mysite.abc/as.php" http://127.0.0.1/web/app_dev.php/api/create

        $data = array(
            'authenticated' => false,
            'created'       => false,
            'address'       => '',
        );

        if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            // == user connected ==
            $data['authenticated'] = true;

            try {
                // create new alias
                $newAlias = new Alias();

                // -- attributs -- // TODO use a manager to create ?
                // url
                $url_value = $request->request->get('url');
                $site_value = $request->request->get('site'); // TODO check if empty !!!
                $newAlias->setSite($site_value);
                $newAlias->setUrl($url_value);
                // user_id
                $user_id = $this->getUserId();
                $newAlias->setUserId($user_id);
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

                // set response
                $data['address'] = $newAlias->getAddress();
                $data['created'] = true;
            } catch (Exception $e) {
                // do nothing
                // it will answer an error
            }
        }

        return new JsonResponse($data);
    }

    private function getUserId()
    {
        return $this->getUser()->getId();
    }

    private function getEntityManager() {
            return $this->getDoctrine()->getEntityManager();
    }
}