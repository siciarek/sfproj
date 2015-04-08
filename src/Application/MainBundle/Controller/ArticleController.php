<?php

namespace Application\MainBundle\Controller;

use Doctrine\ORM\Query;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/article")
 */
class ArticleController extends Controller
{

    /**
     * @Route("/item/{id}", name="article.item")
     * @Template()
     */
    public function itemAction($id)
    {

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
    public function listAction(Request $request)
    {
     //   $request->setLocale('en');

		// $locale = $request->get('locale');

        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();

        $query = $qb
            ->from('\Application\MainBundle\Entity\Article', 'a')
            ->select('a')
            ->getQuery()
			
            ->setHint(
                \Doctrine\ORM\Query::HINT_CUSTOM_OUTPUT_WALKER,
                'Gedmo\\Translatable\\Query\\TreeWalker\\TranslationWalker'
            )			
            ->setHint(
				\Gedmo\Translatable\TranslatableListener::HINT_TRANSLATABLE_LOCALE,
                $request->getLocale()
            )
//            ->setHint(
//                \Gedmo\Translatable\TranslatableListener::HINT_FALLBACK,
//                1 // fallback to default values in case if record is not translated
//            )
            //->setHydrationMode(\Gedmo\Translatable\Query\TreeWalker\TranslationWalker::HYDRATE_OBJECT_TRANSLATION)
            ->setHint(Query::HINT_REFRESH, true)
        ;


        $page  = $request->query->get('page', 1);
        $limit = $this->container->getParameter('pager_limit');
        $items = $this->get('knp_paginator')->paginate($query, $page, $limit);

//        $items = $query->getResult();

        return [
            'items' => $items,
        ];
    }

}
