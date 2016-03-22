<?php

namespace CMS\controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

class PagesController
{
    public function pagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();
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
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();
        $allContent = $db->getAllContent();
        $user = $app['session']->get('user');
        #var_dump($pages);
        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'allcontent' => $allContent,
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
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();
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
        $pageName = $app['request']->get('pagename');
        $pagePath = $app['request']->get('pagepath');
        $pageTemplate = $app['request']->get('pagetemplate');
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $result = $db->createPage($pageName, $pagePath, $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->getAll();

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
        $db = new DbRepository($app['dbh'], 'Page', 'page');

        $user = $app['session']->get('user');
        $pages = $db->getAll();
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
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pageName = $app['request']->get('pagename');
        $pageTemplate = $app['request']->get('pagetemplate');
        $result = $db->deletePage($pageName, $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->getAll();
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
