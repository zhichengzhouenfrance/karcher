<?php

namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

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
    public function loginAction(Request $request)
    {
        if( $request->request->has('identifiant')){

            $identifiant =  $request->request->get('identifiant');

            $pathInfo = $request->getPathInfo();
            $requestUri = $request->getRequestUri();

            $url = str_replace($pathInfo, rtrim($pathInfo, ' /'), 'article');

           // $uri = $this->get('router')->generate('scourgen_web_article_index', array());

           // return $this->redirect($uri, array());

        }

        return array();
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
