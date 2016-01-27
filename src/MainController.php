<?php
namespace LightCMS;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
    /**
     * Class MainController
     * @package LightCMS
     */
class MainController
{
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     * renders a template for the route /home
     */
    public function indexAction(Request $request, Application $app)
    {
        $args_array = array();
        $templateName = 'home';
        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }
}
