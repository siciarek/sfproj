<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * @Route("/menu")
 */
class MenuController extends Controller {

    /**
     * @Route("/main", name="menu.main")
     * @Template()
     */
    public function mainAction($route = null) {

        $menuConfig = realpath(__DIR__ . '/../Resources/config/menu.yml');

        $data = \Symfony\Component\Yaml\Yaml::parse($menuConfig);

        $data['route'] = $route;

        return $data;
    }

}
