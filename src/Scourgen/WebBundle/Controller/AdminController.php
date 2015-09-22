<?php

namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\BaseArticle;
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
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/admin")
 */
class AdminController extends Controller
{
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

    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $session = $request->getSession();
        if($this->loggedIn($session)) {
            // upload file base article
            $em = $this->get('doctrine.orm.entity_manager');
            if ($request->files->get("articleinputfile") != null) {


                $row = 1;
                if (($handle = fopen($request->files->get("articleinputfile"), "r")) !== FALSE) {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                        $num = count($data);
                        $row++;
                        /* echo "<p> $num champs à la ligne $row: <br /></p>\n";*/
                        if ($num > 1) {
                            $articleRepository = $this->getArticleRepository();
                            $reference = $data[0];
                            $article = $articleRepository->find($reference);
                            if (!$article) {
                                $baseArticle = new BaseArticle();
                                $baseArticle->setReference($data[0]);
                                $baseArticle->setLibelle($data[1]);
                                $baseArticle->setPuht($data[2]);
                                $baseArticle->setReferenceFormat($data[3]);
                                $baseArticle->setHierarchie($data[4]);
                                $reference_du_tarif = $data[5];
                                $baseArticle->setValidite($reference_du_tarif);
                                $em->persist($baseArticle);
                                $em->flush();
                            } else {
                                $article->setLibelle($data[1]);
                                $article->setPuht($data[2]);
                                $article->setReferenceFormat($data[3]);
                                $article->setHierarchie($data[4]);
                                $reference_du_tarif = $data[5];
                                $article->setValidite($reference_du_tarif);
                                $em->flush();
                            }

                        }
                    }
                    fclose($handle);
                } else {
                    return array();
                }
            }

            $dql = "SELECT a FROM ScourgenWebBundle:BaseArticle a";
            $query = $em->createQuery($dql);

            $paginator = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $query,
                $request->query->getInt('page', 1)/*page number*/,
                10/*limit per page*/
            );


            return array('pagination' => $pagination);
        }else{
            $uri = $this->get('router')->generate('scourgen_web_login_login', array());
            return $this->redirect($uri);
        }
    }


    /**
     * @Route("/statistiques")
     * @Template()
     */
    public function statistiquesAction(Request $request)
    {

        $statistiquesRepository = $this->getStatistiquesRepository();
        $nombreRechercheToday = $statistiquesRepository->getNombreRechercheToday();
     /*   $nombreRechercheToday = 0;
        if($statistiqueToday){
            $nombreRechercheToday = $statistiqueToday->getRechercheNombre();
        }*/
        $nombreRechercheWeek = $statistiquesRepository->getNombreRechercheWeek();
        $nombreRechercheThisMonth = $statistiquesRepository->getNombreRechercheMonth();
        $nombreRechercheThisYear = $statistiquesRepository->getNombreRechercheYear();

        return new JsonResponse(array('nombre' => array($nombreRechercheToday,$nombreRechercheWeek,$nombreRechercheThisMonth,$nombreRechercheThisYear)));
    }
}