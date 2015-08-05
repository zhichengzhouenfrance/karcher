<?php

namespace Scourgen\WebBundle\Controller;

use Scourgen\WebBundle\Entity\BaseArticle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
/**
 * @Route("/")
 */
class DefaultController extends Controller
{


    /**
     * @return \Scourgen\WebBundle\BaseArticle
     */
    public function getArticleRepository(){
        return  $this->getDoctrine()->getManager()->getRepository('ScourgenWebBundle:BaseArticle');
    }


    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $baseArticleFormPath = "article";

        return array();

    }





}
