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

		$locale = $this->container->get('request')->getLocale();
		
		$locales = LocaleController::$locales;
		
		$loc = [
			'text' => $locales[$locale],
			'icon' => 'globe',
			'children' => [],				
		];
		
		foreach($locales as $code => $lang) {
			$loc['children'][] = [
				'text' => $lang,
				'route' => 'locale.switch',
				'routeParams' => [ 'locale' => $code ],
				'active' => $code === $locale,
			];
		}
		
        $data = \Symfony\Component\Yaml\Yaml::parse($menuConfig);
        $data['route'] = $route;
		
		$data['menu'][] = $loc;

        return $data;
    }

}
