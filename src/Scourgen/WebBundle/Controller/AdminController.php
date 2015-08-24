<?php

namespace Scourgen\WebBundle\Controller;

use Proxies\__CG__\Scourgen\WebBundle\Entity\BaseArticle;
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
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        // upload file base article
        $em = $this->get('doctrine.orm.entity_manager');
        if($request->files->get("articleinputfile") != null){


            $row = 1;
            if (($handle = fopen($request->files->get("articleinputfile"), "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $num = count($data);
                    echo "<p> $num champs à la ligne $row: <br /></p>\n";
                    $row++;
                    $baseArticle = new BaseArticle();
                    $baseArticle->setReference($data[0]);
                    $Eann= $data[1];
                    $baseArticle->setReferenceFormat($data[2]);
                    $baseArticle->setLibelle($data[3]);
                    $baseArticle->setPuht($data[4]);
                    $baseArticle->setHierarchie($data[5]);
                    $reference_du_tarif =  $data[6];
                    $baseArticle->setValidite($reference_du_tarif);
                    $Codepagecatalogue = $data[7];



                    $em->persist($baseArticle);
                    $em->flush();
                }
                fclose($handle);
            }else{
                return array();
            }
        }




        $dql   = "SELECT a FROM ScourgenWebBundle:BaseArticle a";
        $query = $em->createQuery($dql);

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1)/*page number*/,
            10/*limit per page*/
        );


        return array('pagination' => $pagination);
    }
}