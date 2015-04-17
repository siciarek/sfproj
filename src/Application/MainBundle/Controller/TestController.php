<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Application\MainBundle\Entity\Author;

/**
 * @Route("/test")
 */
class TestController extends Controller {

    /**
     * @Route("", name="test.index")
     * @Route("/author/{slug}", name="test.edit")
     * @Template()
     */
    public function indexAction($slug = null) {

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $author = new Author();

        if ($slug != null) {
            $author = $em
                    ->getRepository('\Application\MainBundle\Entity\Author')
                    ->findOneBySlug($slug);
        }

        if (!$author instanceof Author) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm('applicationmain_author_form', $author);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($author);
                $em->flush();

                return $this->redirectToRoute('test.edit', ['slug' => $author->getSlug()]);
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }

}
