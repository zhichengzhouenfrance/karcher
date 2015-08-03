<?php

namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/login")
 */
class LoginController extends Controller
{
    /**
     * @return \Scourgen\WebBundle\UserRepository
     */
    public function getUserRepository(){
        return  $this->getDoctrine()->getManager()->getRepository('ScourgenWebBundle:User');
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function loginAction()
    {
        $user = new User();

        $form = $this->createFormBuilder($user)
            ->setAttribute('class', 'resolved-form exempt-from-default-ajax')
            ->add('identifiant','text')
            ->add('save', 'submit', array(
                'attr' => array('class' => 'btn btn-default'),
            ))
            ->getForm();


        return array('form' => $form->createView(),'test'=>'test');
    }


    /**
     * @Route("/add/{name}")
     * @Template()
     */
    public function addAction($name)
    {
        $user = new User();
        $user->setIdentifiant($name);
        $user->setPassword("password");

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();
        return array('name' => $name);
    }

    /**
     * @Route("/find/{identifiant}")
     * @Template()
     */
    public function findAction($identifiant){
        $userRepository =$this->getUserRepository();

        /** @var  $users \Scourgen\WebBundle\Entity\User */
        $users = $userRepository->getUserByIdentifiant($identifiant);
        foreach($users as  $user){
            echo($user->getIdentifiant());
        }
    }

    /**
     * @Route("/{id}")
     * @ParamConverter("user",class="ScourgenWebBundle:User")
     */
    public function getAction(User $user){
        return new Response($user->getIdentifiant());
    }
}
