<?php

namespace CMS\Controllers;

use CMS\Page;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

class PagesController
{
    // public function pagesAction(Request $request, Application $app)
    // {
    //     $db = new DbRepository($app['dbh']);
    //     #$pages = $db->getAllPages();

    //     #var_dump($pages);
    //     $args_array = array(
    //         'user' => $app['session']->get('user'),

    //         #'pages' => $pages,
    //     );
    //     $templateName = '_pages';

    //     return $app['twig']->render($templateName.'.html.twig', $args_array);
    // }

    public function viewPagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
        );
        $templateName = '_viewPages';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    /**
     * A form to create a new web-page.
     *
     * @param Request     $request the request object
     * @param Application $app     the app object
     *
     * @return twig template        a create-page template
     */
    public function createPageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);

        $args_array = array(
            'user' => $app['session']->get('user'),
        );
        $templateName = '_createPage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * Controller to process creation of a new page.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return twig template
     */
    public function newPageAction(Request $request, Application $app)
    {
        // these variables need to be filtered and sanitised
        // before insert into db.
        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
        $page = new Page();
        $pageRoute = $page->setPageRoute(strtolower($pageName));
        $db = new DbRepository($app['dbh']);
        $result = $db->createPage($pageName, $page->getPageRoute(), $pageTemplate);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
        );
        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * A controller to render the delete page form.
     * 
     * @param request, the request object.
     * @param app, the application object ($app)
     * 
     * @return renders the delete page form.
     */
    public function deletePageAction(Request $request, Application $app)
    {
        $args_array = array(
            'user' => $app['session']->get('user'),

        );
        $templateName = '_deletePage';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * A controller to process deleting a web page.
     * 
     * @param request object
     * @param app, the application object ($app)
     * 
     * @return processes and re-renders the delete page form.
     */
    public function processDeletePageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $pageName = $app['request']->get('pageName');
        $pageTemplate = $app['request']->get('pageTemplate');
        $result = $db->deletePage($pageName, $pageTemplate);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result,
        );
        $templateName = '_dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
