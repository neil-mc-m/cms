<?php
/**
* The main controller.
*/

namespace CMS\Controllers;

use CMS\DbManager;
use CMS\DatabaseTwigLoader;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

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
        $db = new DbRepository($app['dbh']);
        $app['monolog']->addInfo('You just connected to the database');
        # as this is the home page controller, get the home pages content
        $content = $db->getContent('home');

        $args_array = array(
            
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
    public function routeAction(Request $request, Application $app, $pageRoute)
    {
        $db = new DbRepository($app['dbh']);
        $pageName = $db->getPageName($pageRoute);
        $singlePage = $db->getSinglePage($pageName);
        
        $content = $db->getContent($pageName);
        
        $args_array = array(
            'pageName' => $singlePage->getPageName(),
            'content' => $content,
        );

        return $app['twig']->render($singlePage->getPageTemplate().'.html.twig', $args_array);
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
    public function oneArticleAction(Request $request, Application $app, $pageRoute, $contentId)
    {
        $db = new DbRepository($app['dbh']);
        $result = $db->showOne($contentId);

        $args_array = array(
         'contentId' => $result->getContentId(),   
         'pageName' => $result->getPageName(),
         'title' => $result->getContentitemtitle(),
         'article' => $result->getContentitem(),
         'image' => $result->getImagePath(),
         'created' => $result->getCreated()
       );
        $templateName = 'onearticle';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
