<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Entity\User;
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

        $httpCodeStatus = 401; // status: user not authenticated (the id is not recognized)
        $data = array(
            'authenticated' => false,
            'created'       => false,
            'address'       => '',
        );

        // -- check if id given is good --
        // get user_id given
        $user_id = $request->request->get('id'); // TODO : make it better (use crypted id)
        // get user by id in db
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUserBy(array('id'=>$user_id));

        if($user instanceof User) {
            // id given is good

            $data['authenticated'] = true;

            // check datas are good
            $url_value = $request->request->get('url');
            $site_value = $request->request->get('site');
            if(!is_null($url_value) && !is_null($site_value)) {
                // datas are correct
                try {
                    // create new alias
                    $newAlias = new Alias();

                    // -- attributs -- // TODO use a manager to create ?
                    // url
                    $newAlias->setSite($site_value);
                    $newAlias->setUrl($url_value);
                    // user_id
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
                    $httpCodeStatus = 200; // status: good
                } catch (Exception $e) {
                    $httpCodeStatus = 503; // status: service unavailable or under maintenance
                }
            }

        }

        return new JsonResponse($data, $httpCodeStatus);
    }

    private function getUserId()
    {
        return $this->getUser()->getId();
    }

    private function getEntityManager() {
            return $this->getDoctrine()->getEntityManager();
    }
}