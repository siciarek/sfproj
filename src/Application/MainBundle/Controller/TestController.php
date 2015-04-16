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
     * @Route("/author/{id}", name="test.edit")
     * @Template()
     */
    public function indexAction($id = null) {

        $request = $this->get('request');
        $em = $this->getDoctrine()->getManager();

        $author = new Author();

        $id = intval($request->get('id', null));

        if ($id > 0) {
            $author = $em->getRepository('\Application\MainBundle\Entity\Author')->find($id);
        }

        if (!$author instanceof Author) {
            throw $this->createNotFoundException();
        }

        $type = new \Application\MainBundle\Form\AuthorForm();

        $form = $this->createForm($type, $author);

        if ($request->getMethod() === 'POST') {

            $form->handleRequest($request);

            if ($form->isValid()) {

                $em->persist($author);
                $em->flush();

                return $this->redirectToRoute('test.edit', ['id' => $author->getId()]);
            }
        }

        return [
            'form' => $form->createView(),
        ];
    }

}
