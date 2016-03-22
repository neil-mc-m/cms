<?php
/**
 * the admin controller.
 */

namespace LightCMS\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;

/**
 * The controller class for all admin CRUD actions.
 *
 * @class AdminController
 */
class AdminController
{
    /**
     * Load the admins dashboard.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return [type] twig template for admin/dashboard
     */
    public function dashboardAction(Request $request, Application $app)
    {
        $user = $app['security.token_storage']->getToken()->getUser()->getUsername();
        $app['session']->set('user', array('username' => $user));
        $user = $app['session']->get('user');
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
        );
        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
