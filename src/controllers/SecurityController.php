<?php
namespace LightCMS\controllers;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;

/**
 * The security controller responsible for logging in.
 *
 * @class SecurityController
 *
 */
class SecurityController
{
    /**
     * A controller to handle logging in.
     * @param  Request     $request current request object
     * @param  Application $app     current app instance
     * @return twig template        a log in form
     */
    public function logInAction(Request $request, Application $app)
    {
        $args_array = array(

        );
        $templateName = 'login';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function loginCheckAction(Request $request, Application $app)
    {
        $token = $app['security.token_storage']->getToken();
        var_dump($token);
        $args_array = array();
        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function logoutAction(Request $request, Application $app)
    {

        return $app->redirect('/');
    }
}
