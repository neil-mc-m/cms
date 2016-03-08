<?php

namespace LightCMS\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;


class AdminController
{
    public function dashboardAction(Request $request, Application $app)
    {
        $user = $app['security.token_storage']->getToken()->getUser()->getUsername();
        $app['session']->set('user', array('username' => $user));




        $args_array = array(
            'user' => $user,
            'id' => session_id()
        );
        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
