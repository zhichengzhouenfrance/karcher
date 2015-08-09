<?php

namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\User;
use Scourgen\WebBundle\Entity\RedirectResponseWithCookie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @Route("/login")
 */
class LoginController extends Controller
{
    private $identifiantName = "identifiant";

    /**
     * @return \Scourgen\WebBundle\UserRepository
     */
    public function getUserRepository(){
        return  $this->getDoctrine()->getManager()->getRepository('ScourgenWebBundle:User');
    }


    public function loggedIn($session){
        $loggedIn = false;
        if($session->has('identifiant')||isset($_COOKIE['identifiant']))
            $loggedIn = true;
        return $loggedIn;
    }

    /**
     * @Route("/")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $identifiantName = "identifiant";
        $session = $request->getSession();
        $cookie = $request->cookies;
        if(!$this->loggedIn($session)){
            if( $request->request->has("identifiant")){
                $identifiant =  $request->request->get($identifiantName);
                $userRepository = $this->getUserRepository();
                $users = $userRepository->getUserByIdentifiant($identifiant);
                if(count($users)>0){
                   $user =  array_shift ( $users );
                    //if user is not admin;
                    if(!$user->getProfile()){
                        //put login into the session symfony
                        $session->set($identifiantName, $identifiant);
                        $_SESSION['identifiant'] = $identifiant;
                        //get uri of search article page
                        $uri = $this->get('router')->generate('scourgen_web_article_index', array());
                        //is the user set remember the login
                        if($request->request->get("rememberme")){
                            $cookie = new Cookie($identifiantName, $identifiant,time() +
                                (3600 * 48));
                            $response = new RedirectResponse($uri);
                            $response->headers->setCookie($cookie);
                            return $response;
                        }
                        //redirect to search product page
                        return $this->redirect($uri);
                    }else{
                        //if user is admin
                        if(!$request->request->has("password")){
                            return array(
                                'adminNeedPasswordAuthentification' => true,
                                'error' => "",
                                'password_error'=>"",
                                'adminLogin'=> $identifiant
                            );
                        }else{
                            //user admin's password is correct
                            if($request->request->get("password")==$user->getPassword()){
                                //put login into the session symfony
                                $session->set($identifiantName, $identifiant);
                                //get uri of search article page
                                $uri = $this->get('router')->generate('scourgen_web_admin_index', array());
                                //is the user set remember the login
                                if($request->request->get("rememberme")){
                                    $cookie = new Cookie($identifiantName, $identifiant,time() +
                                        (3600 * 48));
                                    $response = new RedirectResponse($uri);
                                    $response->headers->setCookie($cookie);
                                    return $response;
                                }
                                //redirect to administration page
                                return $this->redirect($uri);
                            }
                            //user admin 's password is not correct
                            else{
                                return array(
                                    'error' => "votre identifiant n'est connais pas",
                                    'adminNeedPasswordAuthentification' => true,
                                    'adminLogin'=> $identifiant,
                                    'password_error' => "votre mot de passe n'est connais pas"
                                );
                            }
                        }
                    }

                }
                //identifiant n'est pas valide
                return array(
                    'error' => "votre identifiant n'est connais pas",
                    'adminNeedPasswordAuthentification' => false,
                    'adminLogin'=> ''
                );
            }
            return array(
                'error' => "",
                'adminNeedPasswordAuthentification' => false,
                'adminLogin'=> ''
            );
        }else{
            $uri = $this->get('router')->generate('scourgen_web_article_index', array());
             return $this->redirect($uri);
         }
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
     * @Route("/disconnect")
     * @Template()
     */
    public function disconnectAction(Request $request){
        $session = $request->getSession();
        $session->remove("identifiant");
        //setcookie("identifiant", "", time()-3600);


        /*
         *  a faire supprimer le cookie identifiant
         *  apres le
         *
         * */
        unset($_COOKIE['identifiant']);
        setcookie('identifiant', null, -1, '/');

        return array();
    }
}
