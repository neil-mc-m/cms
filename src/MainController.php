<?php
/**
* The main controller.
*/

namespace LightCMS;

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
        $args_array = array();
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
    public function articlesAction(Request $request, Application $app)
    {
        # class name and tablename need to be passed as parameters
        $db = new DbRepository('Articles', 'articles');
        $result = $db->showAllArticles();
        $args_array = array(
         'articles' => $result,
       );
        $templateName = 'articles';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
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
    public function oneArticleAction(Request $request, Application $app)
    {
        $db = new DbRepository('Articles', 'articles');
        $id = $request->get('id');
        $result = $db->showOneArticle($id);
        $args_array = array(
         'article' => $result,
       );
        $templateName = 'onearticle';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
