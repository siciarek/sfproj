<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="default.home")
     * @Template()
     */
    public function indexAction()
    {
        return [];
    }

    /**
     * @Route("/contact", name="default.contact")
     * @Template()
     */
    public function contactAction()
    {
        return [];
    }
    
    /**
     * @Route("/locale/switch/{locale}", name="locale.switch")
     */
    public function switchAction($locale) 
    {
        $this->get('request')->setLocale($locale);
        return $this->redirect('/');
    }
}
