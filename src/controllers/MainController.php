<?php
/**
* The main controller.
*/

namespace LightCMS\controllers;

use LightCMS\DbManager;
use LightCMS\DatabaseTwigLoader;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use LightCMS\DbRepository;

/**
 * The Main Controller used for the 'main' routes out of index.php.
 *
 * @Class MainController.
 */
class MainController
{
    /**
     * home page Controller.
     *
     * Renders a template for the homepage.
     *
     * @param Request     $request
     * @param Application $app
     *
     * @return homepage template
     */
    public function indexAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $app['monolog']->addInfo('You just connected to the database');
        # get all pages currently stored in the db.
        # Used for building the navbar and setting page titles.
        $pages = $db->getAll();

        # as this is the home page controller, get the home pages content
        $content = $db->getContent('home');

        $args_array = array(
            'pages' => $pages,
            'content' => $content,
        );
        $templateName = 'home';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    /**
     * display all articles.
     *
     * renders a template with all articles listed.
     *
     * @param Request
     * @param Application
     *
     * @return the articles template.
     */
    // public function articlesAction(Request $request, Application $app)
    // {
    //     # class name and tablename need to be passed as parameters
    //     $db = new DbRepository('Articles', 'articles');
    //     $result = $db->showAll();
    //     var_dump($result);
    //     $args_array = array(
    //      'articles' => $result,
    //    );
    //     $templateName = 'articles';
    //
    //     return $app['twig']->render($templateName.'.html.twig', $args_array);
    // }



    /**
     * Main routing out of the home page.
     *
     * @param Request     $request [description]
     * @param Application $app     [description]
     * @param string      $page    the route/link used from the home page
     *
     * @return twig template        the requested twig template.
     */
    public function routeAction(Request $request, Application $app, $page)
    {
        # get the pages to build the navbar
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();

        $content = $db->getContent($page);

        $args_array = array(
            'pages' => $pages,
            'content' => $content,
        );

        return $app['twig']->render($page.'.html.twig', $args_array);
    }
    /**
     * display one articles.
     *
     * renders a template with one articles.
     *
     * @param Request
     * @param Application
     *
     * @return an article template.
     */
    public function oneArticleAction(Request $request, Application $app, $page, $contentid)
    {
        $db = new DbRepository($app['dbh'], 'Page', 'page');
        $pages = $db->getAll();


        $result = $db->showOne($contentid);
        var_dump($result);
        $args_array = array(
         'pages' => $pages,
         'pagename' => $result->getPageName(),
         'title' => $result->getContentitemtitle(),
         'article' => $result->getContentitem(),
         'created' => $result->getCreated()
       );
        $templateName = 'onearticle';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
