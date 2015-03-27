<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/info")
 */
class InfoController extends Controller
{
    /**
     * @Route("/help", name="info.help")
     * @Template()
     */
    public function helpAction()
    {
        return [];
    }

    /**
     * @Route("/about", name="info.about")
     * @Template()
     */
    public function aboutAction()
    {
        return [];
    }

    /**
     * @Route("/authors", name="info.authors")
     * @Template()
     */
    public function authorsAction()
    {
        return [];
    }
}
