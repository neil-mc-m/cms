<?php

namespace LightCMS\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;
use PDO;

class PagesController
{
    public function pagesAction(Request $request, Application $app)
    {
        $db = new DbRepository('Page', 'page');
        $pages = $db->showAll();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages
        );
        $templateName = 'admin/pages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    public function viewPagesAction(Request $request, Application $app)
    {
        $db = new DbRepository('Page', 'page');
        $pages = $db->showAll();
        $allContent = $db->getAllContent();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'allcontent' => $allContent
        );
        $templateName = 'admin/viewPages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    /**
     * Create a new web-page.
     *
     * @param  Request     $request the request object
     * @param  Application $app     the app object
     * @return twig template        a create-page template
     */
    public function createPageAction(Request $request, Application $app)
    {
        $db = new DbRepository('Page', 'page');
        $pages = $db->showAll();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages
        );
        $templateName = 'admin/createPage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Controller to create a new page.
     *
     * @param  Request     $request
     * @param  Application $app
     * @return twig template
     */
    public function newPageAction(Request $request, Application $app)
    {
        $pageName = $app['request']->get('pagename');
        $pagePath = $app['request']->get('pagepath');
        $pageTemplate = $app['request']->get('pagetemplate');
        $db = new DbRepository('Page', 'page');
        $result = $db->createPage($pageName, $pagePath, $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->showAll();
        var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'result' => $result
        );
        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function deletePageAction(Request $request, Application $app)
    {
        $db = new DbRepository('Page', 'page');

        $user = $app['session']->get('user');
        $pages = $db->showAll();
        var_dump($pages);
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
        $db = new DbRepository('Page', 'page');
        $pageName = $app['request']->get('pagename');
        $result = $db->deletePage($pageName);
        $user = $app['session']->get('user');
        $pages = $db->showAll();
        var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'result' => $result
        );
        $templateName = 'admin/deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

}
