<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;
/**
 * The Content Controller class.
 * 
 * Used for processing requests for content. CRUD actions on content
 * 
 * 
 */
class ContentController
{
    /**
     * 
     * 
     */ 
     
    public function contentAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $app['monolog']->addInfo('You just connected to the database');
        # get all pages currently stored in the db.
        # Used for building the navbar and setting page titles.
        
        $content = $db->getAllPagesContent();

        $args_array = array(
            'content' => $content,
            'user' => $app['session']->get('user')
        );

        $templateName = '_content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function singleContentAction(Request $request, Application $app, $contentid)
    {
        $db = new DbRepository($app['dbh']);
        
        $content = $db->showOne($contentid);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'contentitemtitle' => $content->getContentItemTitle(),
            'contentitem' => $content->getContentItem(),
            'created' => $content->getCreated(),
            'contentid' => $content->getContentId()
            );

        $templateName = 'singleContent';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    public function createContentFormAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);

        $args_array = array(
            'user' => $app['session']->get('user')
        );

        $templateName = 'contentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function processContentAction(Request $request, Application $app)
    {
        $pageName = $app['request']->get('pageName');
        $contentType = $app['request']->get('contentType');
        $contentItemTitle = $app['request']->get('contentItemTitle');
        $contentItem = $app['request']->get('contentItem');
        $db = new DbRepository($app['dbh']);
        $app['monolog']->addInfo('You just connected to the database');
        $result = $db->createContent($pageName, $contentType, $contentItemTitle, $contentItem);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result
            );

        $templateName = 'dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function deleteContentFormAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $allContent = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'allcontent' => $allContent
        );

        $templateName = 'deleteContentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processDeleteContentAction(Request $request, Application $app, $contentid)
    {
        $db = new DbRepository($app['dbh']);
        $result = $db->deleteContent($contentid);
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
            'result' => $result
            );

        $templateName = 'content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);

    }

    public function editContentAction(Request $request, Application $app, $contentId)
    {
        $db = new DbRepository($app['dbh']);
        $content  = $db->showOne($contentId);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content
            );

        $templateName = 'editContentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processEditContentAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $contentId = $app['request']->get('contentId');
        $pageName = $app['request']->get('pageName');
        $contentType = $app['request']->get('contentType');
        $contentItemTitle = $app['request']->get('contentItemTitle');
        $contentItem = $app['request']->get('contentItem');
        $result = $db->editContent($contentId, $pageName, $contentType, $contentItemTitle, $contentItem);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'result' => $result    
            );

        $templateName = 'dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
