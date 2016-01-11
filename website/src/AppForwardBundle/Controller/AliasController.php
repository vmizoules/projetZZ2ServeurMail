<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use AppForwardBundle\Repository\Mysql;
use AppForwardBundle\Manager\MailAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Exception as Exception;
use \DateTime;

class AliasController extends Controller
{
    public function listAction()
    {
        $aliasRepository = $this->getAliasRepository();

        $alias = $aliasRepository->findBy(
            array("user_id" => $this->getUserId())
        );

        echo "<pre>";
        var_dump($alias);
        exit("");
    }

    public function addAction(Request $request)
    {
        // 1) build the form
        $newAlias = new Alias();
        $form = $this->createForm(AliasType::class, $newAlias);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // set user id in newAlias
            $userId = $this->getUserId();
            $newAlias->setUserId($userId);

            // set random Address in newAlias
            $aliasAddress = MailAddress::generateMailAddress($newAlias->getUserId(), $newAlias->getSite());
            $newAlias->setAddress($aliasAddress);

            // set created & modified at now
            $now = new DateTime('now');
            $newAlias->setCreated($now);
            $newAlias->setModified($now);

            /*$database = new Mysql($this->getDoctrine());
            $database->createAlias($newAlias);*/

            $entityManager = $this->getEntityManager();
            $entityManager->persist($newAlias);
            $entityManager->flush();

            // todo : clean it !
            exit("TODO: save it !");

            //return $this->redirectToRoute('replace_with_some_route');
        }

        return $this->render(
            'AppForwardBundle:Form:alias.html.twig',
            array('form' => $form->createView())
        );
    }

    public function updateAction(Request $request, $id)
    {
        try {
            // check & get alias associated with user (and exists)
            $alias = $this->getAliasAssociatedUser($id, $this->getUserId());
        } catch(Exception $e){
            // TODO make it better
            exit("not good");
        }

        // 1) build the form
        $form = $this->createForm(AliasType::class, $alias);

        // 2) handle the submit (will only happen on POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // set modified at now
            $now = new DateTime('now');
            $alias->setModified($now);

            // flush db
            $this->getEntityManager()->flush();

            // todo : clean it !
            exit("good");
            //return $this->redirectToRoute('replace_with_some_route');*/
        }

        return $this->render(
            'AppForwardBundle:Form:alias.html.twig',
            array('form' => $form->createView())
        );
    }

    public function deleteAction($id)
    {
        try {
            // check & get alias associated with user (and exists)
            $alias = $this->getAliasAssociatedUser($id, $this->getUserId());
        } catch(Exception $e){
            // TODO make it better
            exit("not good");
        }

        $em = $this->getEntityManager();
        $em->remove($alias);
        $em->flush();

        // TODO make it better
        exit("good");
    }

    public function enableAction($id)
    {
        $this->changeAliasStatus($id, 1);
    }

    public function disableAction($id)
    {
        $this->changeAliasStatus($id, 0);
    }


    private function getEntityManager() {
        return $this->getDoctrine()->getEntityManager();
    }

    private function getAliasRepository()
    {
        return $this->getEntityManager()->getRepository('AppForwardBundle:Alias');
    }

    private function getUserId()
    {
        return $this->getUser()->getId();
    }

    private function getAliasAssociatedUser($id, $user_id)
    {
        // check this email is associated with this user
        $aliasRepository = $this->getAliasRepository();
        $alias = $aliasRepository->findOneBy(
            array(
                "address" => $id,
                "user_id" => $user_id,
            )
        );

        // not exist or not associated with user
        if (!$alias) {
            throw new Exception("User not found or not associated with this alias");
        }

        return $alias;
    }

    private function changeAliasStatus($id, $enabled_value)
    {
        try {
            // check & get alias associated with user (and exists)
            $alias = $this->getAliasAssociatedUser($id, $this->getUserId());
        } catch(Exception $e){

            // TODO make it better
            exit("not good");
        }

        // disable or enable alias
        $alias->setEnabled($enabled_value);
        // save
        $this->getEntityManager()->flush();

        // todo redirect after this !
        exit("good");
    }
}
