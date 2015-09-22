<?php
namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\Statistiques;
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

    public function getStatistiquesRepository(){
        return  $this->getDoctrine()->getManager()->getRepository('ScourgenWebBundle:Statistiques');
    }


    public function loggedIn($session){
        $loggedIn = false;
        if($session->has('identifiant')||isset($_COOKIE['identifiant']))
            $loggedIn = true;
        return $loggedIn;
    }

    public function getIdentifiant($session){
        $identifiant = null;
        if($session->has('identifiant')){
            $identifiant = $_SESSION['identifiant'];
        }elseif(isset($_COOKIE['identifiant'])){
            $identifiant = $_COOKIE['identifiant'];
        }
        return $identifiant;
    }


    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($this->loggedIn($session)){
            return array('reference' => '');
        }else{
            $uri = $this->get('router')->generate('scourgen_web_login_login', array());
            return $this->redirect($uri);
        }
    }

    /**
     * @Route("/find/")
     * @Template()
     */
    public function findAction(Request $request)
    {
        $reference = '';
        if($request->request->has('reference') && $request->request->get('reference') != ''){

            $reference = $request->request->get('reference');
            $articleRepository  = $this->getArticleRepository();
            $articles = $articleRepository->getArticleByReference($reference);
            if(count($articles)>0){
                $article =  array_values($articles)[0];
                //mettre à jour la table Statistiques
                $session = $request->getSession();
                $identifiant = $this->getIdentifiant($session);
                $now = new \DateTime();
                $rechercheDate = strtotime("Today");
                $idStatistique = $identifiant.$rechercheDate;
                $statistiquesRepository = $this->getStatistiquesRepository();
                $statistiqueTodayForUser = $statistiquesRepository->find($idStatistique);
                $em = $this->get('doctrine.orm.entity_manager');
                if(!$statistiqueTodayForUser){
                    $statistique = new Statistiques();
                    $statistique->setRechercheDate($rechercheDate);
                    $statistique->setRechercheNombre(1);
                    $statistique->setIdentifiant($identifiant);
                    $date = $now->format("Y-m-d");
                    $statistique->setDate($date);
                    $statistique->setId($idStatistique);
                    $em->persist($statistique);
                    $em->flush();
                }else{
                    $nombre = $statistiqueTodayForUser->getRechercheNombre();
                    $nombre = $nombre +1;
                    $statistiqueTodayForUser->setRechercheNombre($nombre);
                    $em->flush();
                }
                return  array('article' => $article,'reference'=>$reference,'error_message'=>"");
            }else{
                return  array('article' => '','reference'=>'','error_message'=>"Aucun résultat ne correspond à votre recherche.");
            }
        }
        return  array('article' => '','reference' => $reference,'error_message'=>"Aucun résultat n'est proposé si aucune référence d'article n'est saisie");
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
