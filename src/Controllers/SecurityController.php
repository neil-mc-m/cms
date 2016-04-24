<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * The security controller responsible for logging in.
 *
 * @class SecurityController
 */
class SecurityController
{
    /**
     * A controller to handle logging in.
     *
     * @param Request     $request current request object
     * @param Application $app     current app instance
     *
     * @return twig template        a log in form
     */
    public function logInAction(Request $request, Application $app)
    {
        $token = $app['security.token_storage']->getToken();
        
        $args_array = array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        );
        $templateName = 'login';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    // public function loginCheckAction(Request $request, Application $app)
    // {
    //
    // $username = $request->get('username');
    // $password = $request->get('password');
    //
    // $userProvider = new CustomUserProvider();
    // $user = $userProvider->loadUserbyUsername($username);
    // var_dump($user);
    // if ($user->getPassword() == $password){
    //     return $app['twig']->render('admin/dashboard.html.twig');
    // }
    // else{
    //     return $app['twig']->render('login.html.twig', array(
    //         'error' => $app['security.last_error']($request),
    //         'last_username' => $app['session']->get('_security.last_username'),
    //     ));
    // }

    //     $args_array = array();
    //     $templateName = 'admin/dashboard';
    //
    //     return $app['twig']->render($templateName.'.html.twig', $args_array);
    //
    // }
    public function logoutAction(Request $request, Application $app)
    {
        return $app->redirect('/');
    }
}
