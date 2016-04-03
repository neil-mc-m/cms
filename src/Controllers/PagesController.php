<?php

namespace CMS\Controllers;

use CMS\Page;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

class PagesController
{
    public function pagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        #$pages = $db->getAllPages();
        
        #var_dump($pages);
        $args_array = array(
            'user' => $app['session']->get('user'),
            
            #'pages' => $pages,
        );
        $templateName = 'pages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function viewPagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        #$pages = $db->getAllPages();
        $content = $db->getAllPagesContent();
       
        #var_dump($pages);
        $args_array = array(
            'user' => $app['session']->get('user'),
            #'pages' => $pages,
            'content' => $content,
        );
        $templateName = 'viewPages';

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
        #var_dump($pages);
        $args_array = array(
            'user' => $app['session']->get('user'),
            
            #'pages' => $pages,
        );
        $templateName = 'createPage';

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
        $page = new Page();
        $pageRoute = $page->setPageRoute($pageName);
        $db = new DbRepository($app['dbh']);
        $result = $db->createPage($pageName, $page->getPageRoute(), $pageTemplate);
        $user = $app['session']->get('user');
        $pages = $db->getAllPages();

        $args_array = array(
            'user' => $user,
            'id' => session_id(),
            'pages' => $pages,
            'result' => $result,
        );
        $templateName = 'dashboard';

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
        $templateName = 'deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processDeletePageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
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
        $templateName = 'deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
