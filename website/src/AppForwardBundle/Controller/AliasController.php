<?php

namespace AppForwardBundle\Controller;

use AppForwardBundle\Entity\Alias;
use AppForwardBundle\Form\AliasType;
use AppForwardBundle\Manager\MailAddress;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use \Exception as Exception;
use \DateTime;

class AliasController extends Controller
{
    public function listAction()
    {
        // get repo
        $aliasRepository = $this->getAliasRepository();

        // get aliases
        $aliases = $aliasRepository->findBy(
            array("user_id" => $this->getUserId())
        );

        // display it
        return $this->render('AppForwardBundle:Pages:alias_list.html.twig',
            array(
                'aliases' => $aliases,
            )
        );
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

            // create in db
            $entityManager = $this->getEntityManager();
            $entityManager->persist($newAlias);
            $entityManager->flush();

            // return to alias list
            return $this->redirectToRoute('app_forward_alias_list');
        }

        return $this->render(
            'AppForwardBundle:Pages:alias_add.html.twig',
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

            // return to alias list
            return $this->redirectToRoute('app_forward_alias_list');
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

        // return to alias list
        return $this->redirectToRoute('app_forward_alias_list');
    }

    public function enableAction($id)
    {
        return $this->changeAliasStatus($id, 1);
    }

    public function disableAction($id)
    {
        return $this->changeAliasStatus($id, 0);
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
        // set modified at now
        $now = new DateTime('now');
        $alias->setModified($now);
        // save
        $this->getEntityManager()->flush();

        // return to alias list
        return $this->redirectToRoute('app_forward_alias_list');
    }
}
