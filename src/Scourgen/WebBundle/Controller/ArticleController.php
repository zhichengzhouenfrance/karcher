<?php
namespace Scourgen\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Scourgen\WebBundle\Entity\BaseArticle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
/**
 * @Route("/article")
 */
class ArticleController extends Controller
{
    private $identifiantName = "identifiant";

    /**
     * @return \Scourgen\WebBundle\BaseArticle
     */
    private function isUserConnected($session){
        if($session->has("identifiant"))
            return true;
        return false;
    }

    public function getArticleRepository(){
        return  $this->getDoctrine()->getManager()->getRepository('ScourgenWebBundle:BaseArticle');
    }

    public function loggedIn(){
        $loggedIn = false;
        if(isset($_SESSION['identifiant'])||isset($_COOKIE['identifiant']))
            $loggedIn = true;
        return $loggedIn;
    }


    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($this->loggedIn()){
            return array('reference' => '');
        }else{
            $uri = $this->get('router')->generate('scourgen_web_login_login', array());
            return $this->redirect($uri);
        }
    }

    /**
     * @Route("/find/")
     * @Method({"POST"})
     * @Template()
     */
    public function findAction(Request $request)
    {
        if($request->request->has('reference')){
            $reference = $request->request->get('reference');
            $articleRepository  = $this->getArticleRepository();
            $articles = $articleRepository->getArticleByReference($reference);
            if(count($articles)>0){
                $article =  array_values($articles)[0];
                return  array('article' => $article,'reference'=>$reference);
            }
        }

        return  array('reference' => $reference);

    }


    /**
     * @Route("/autocomplete/")
     * @Method({"POST"})
     */
    public function autocompleteAction(Request $request)
    {
        if($request->request->has('term')){
            $reference = $request->request->get('term');
            $articleRepository  = $this->getArticleRepository();
            $articles = $articleRepository->autoCompleteByReference($reference);
            $autoCompleteResponse = array();
            if(count($articles)>0){
                foreach ($articles as $article){
                    array_push($autoCompleteResponse, $article->getReference());
                }
            }
        }

        return new JsonResponse($autoCompleteResponse);

    }
    /**
     * @Route("/find/autocomplete/")
     * @Method({"POST"})
     */
    public function findAutocompleteAction(Request $request)
    {
        if($request->request->has('term')){
            $reference = $request->request->get('term');
            $articleRepository  = $this->getArticleRepository();
            $articles = $articleRepository->autoCompleteByReference($reference);
            $autoCompleteResponse = array();
            if(count($articles)>0){
                foreach ($articles as $article){
                    array_push($autoCompleteResponse, $article->getReference());
                }
            }
        }

        return new JsonResponse($autoCompleteResponse);

    }
}
