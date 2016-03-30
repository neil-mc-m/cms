<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

class PagesController
{
    public function pagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pages = $db->getAllPages();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
        );
        $templateName = 'admin/pages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function viewPagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pages = $db->getAllPages();
        $content = $db->getAllPagesContent();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'content' => $content,
        );
        $templateName = 'admin/viewPages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    /**
     * Create a new web-page.
     *
     * @param Request     $request the request object
     * @param Application $app     the app object
     *
     * @return twig template        a create-page template
     */
    public function createPageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pages = $db->getAllPages();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
        );
        $templateName = 'admin/createPage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Controller to create a new page.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return twig template
     */
    public function newPageAction(Request $request, Application $app)
    {
        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
        $db = new DbRepository($app['dbh']);
        $result = $db->createPage($pageName, $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->getAllPages();

        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'result' => $result,
        );
        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function deletePageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);

        $user = $app['session']->get('user');
        $pages = $db->getAllPages();
        
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,

        );
        $templateName = 'admin/deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processDeletePageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pageName = $app['request']->get('pagename');
        $pageTemplate = $app['request']->get('pagetemplate');
        $result = $db->deletePage($pageName, $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->getAllPages();
        var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'result' => $result,
        );
        $templateName = 'admin/deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
