<?php
namespace LightCMS;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
    /**
     * Class MainController
     * @package LightCMS
     * the main controller used to direct the user through the 4 main routes
     * as set by the front controller, index.php.
     * These routes correspond to the navigation bar links
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
        $templateName = 'base';
        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }
}
