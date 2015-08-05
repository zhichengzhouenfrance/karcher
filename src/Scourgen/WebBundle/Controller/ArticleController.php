<?php
namespace Scourgen\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Scourgen\WebBundle\Entity\BaseArticle;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
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
        
        return array();

    }

    /**
     * @Route("/{reference}")
     * @Method({"GET"})
     * @Template()
     */
    public function findAction($reference)
    {
        $articleRepository  = $this->getArticleRepository();
        $articles = $articleRepository->getArticleByReference($reference);
        foreach($articles as  $article){
            echo($article->getLibelle());
        }

        return array();

    }
}
