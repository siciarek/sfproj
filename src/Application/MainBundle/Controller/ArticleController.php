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
     * @Route("/item/{id}", name="article.item", requirements={"id"="^[1-9]\d*$"})
     * @Template()
     */
    public function itemAction($id) {
        $query = $this->createQuery($id);
        $items = $query->getResult();

        if (count($items) !== 1) {
            throw $this->createNotFoundException();
        }

        $item = array_pop($items);

        return [
            'item' => $item,
        ];
    }

    /**
     * @Route("/list", name="article.list")
     * @Template()
     */
    public function listAction(Request $request) {
        $query = $this->createQuery();
        $page = $request->query->get('page', 1);
        $limit = $this->container->getParameter('pager_limit');
        $items = $this->get('knp_paginator')->paginate($query, $page, $limit);

        return [
            'items' => $items,
        ];
    }

    protected function createQuery($id = null) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $qb
                ->from('\Application\MainBundle\Entity\Article', 'a')
                ->select('a')
        ;

        if ($id !== null) {
            $qb->andWhere('a.id = :id')->setParameter('id', $id);
        }

        $query = $qb->getQuery()
                ->setHint(
                        \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER, 'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
                )
                ->setHint(
                        \Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE, $this->container->get('request')->getLocale()
                )
                ->setHint(
                \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK, 1
                )
        ;

        return $query;
    }

}
