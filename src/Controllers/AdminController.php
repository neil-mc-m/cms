<?php
/**
 * the admin controller.
 */

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

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
        $db = new DbRepository($app['dbh']);

        $args_array = array(
            'user' => $app['session']->get('user'),

        );

        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
