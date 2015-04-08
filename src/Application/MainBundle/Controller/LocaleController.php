<?php

namespace Application\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/locale")
 */
class LocaleController extends Controller
{
    public static $locales = array(
        'pl' => 'Polski',
        'en' => 'English',
//        'cz' => 'Èeština',
//        'sl' => 'Slovenskı',
//        'de' => 'Deutsch',
//        'ru' => '???????',
//        'hu' => 'Magyar',
//        'sv' => 'Svenska',
//        'ro' => 'Român',
//        'uk' => '???????????',
    );

    protected $default_locale = 'en';

    /**
     * @Route("/switch/{locale}", name="locale.switch", requirements = {"locale"="^[a-z]{2}$"})
     */
    public function changeLocaleAction($locale) {

        $locale = in_array($locale, array_keys(self:: $locales)) ? $locale : $this->default_locale;

        $session = $this->getRequest()->getSession();
        $session->set('locale', $locale);

        $referer = $this->getRequest()->server->get('HTTP_REFERER');

        // Handling dev environent when no referer was found.
        if($referer === null) {
            $script_name = $this->getRequest()->getScriptName();
            $referer = $this->getRequest()->getSchemeAndHttpHost();
            $referer .= preg_match('/dev/', $script_name) > 0 ? $script_name . '/' : '';
        }

        return $this->redirect($referer);
    }
}
