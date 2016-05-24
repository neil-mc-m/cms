<?php

namespace CMS\Controllers;


use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;
use CMS\Image;

/**
 * The image controller used to view, add and upload image routes.
 *
 * @Class ImageController
 */
class ImageController
{
    /**
     * A route to retrieve images from the database and present
     * them to the user for adding to content.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function viewImagesAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $images = $db->viewImages();
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'images' => $images,
            'content' => $content,
        );

        $templateName = '_viewImages';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    /**
     * A controller for adding images to an article.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function addImageAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $contentId = $app['request']->get('contentId');
        $imagePath = $app['request']->get('imagePath');

        $result = $db->addImage($imagePath, $contentId);
        $content = $db->showOne($contentId);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'image' => $content->getImagePath(),
            'contentitemtitle' => $content->getContentItemTitle(),
            'contentitem' => $content->getContentItem(),
            'created' => $content->getCreated(),
            'contentid' => $content->getContentId(),
            'result' => $result,
        );
        $templateName = '_singleContent';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    /**
     * A controller for rendering the upload images form.
     *
     * @param request object
     * @param app object
     *
     * @return twig template
     */
    public function uploadImageFormAction(Request $request, Application $app)
    {
        #$db = new DbRepository($app['dbh']);

        $args_array = array(
            'user' => $app['session']->get('user'),

        );
        $templateName = '_uploadImageForm';

        return $app['twig']->render($templateName . '.html.twig', $args_array);
    }

    
   
}
