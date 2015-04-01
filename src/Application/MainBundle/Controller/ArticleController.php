<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/article")
 */
class ArticleController extends Controller {

    /**
     * @Route("/item/{id}", name="article.item")
     * @Template()
     */
    public function itemAction($id) {
        
        $item = $this->getDoctrine()
                ->getManager()
                ->getRepository('\Application\MainBundle\Entity\Article')
                ->findOneBy(['id' => $id]);
        
        return [
            'item' => $item,
        ];
    }
    
    /**
     * @Route("/list", name="article.list")
     * @Template()
     */
    public function listAction(Request $request) {
        
        $qb = $this->getDoctrine()->getManager()->createQueryBuilder();
        
        $query = $qb
                ->from('\Application\MainBundle\Entity\Article', 'a')
                ->select('a')
                ->getQuery()
        ;

        $paginator = $this->get('knp_paginator');
        $page = $request->query->get('page', 1);
        $limit = $this->container->getParameter('pager_limit');

        $items = $paginator->paginate($query, $page, $limit);

        return [
            'items' => $items,
        ];
    }

}
