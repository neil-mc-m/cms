<?php

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;

class ContentController
{
    public function contentAction(Request $request, Application $app)
    {
        $db = new DbRepository($app['dbh']);
        $app['monolog']->addInfo('You just connected to the database');
        # get all pages currently stored in the db.
        # Used for building the navbar and setting page titles.
        $pages = $db->getAllPages();
        $content = $db->getAllPagesContent();

        $args_array = array(
            'content' => $content,
            'pages' => $pages,
            'user' => $app['session']->get('user')
        );

        $templateName = 'admin/content';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function singleContentAction(Request $request, Application $app, $contentid)
    {
        $db = new DbRepository($app['dbh']);
        $pages = $db->getAllPages();
        $content = $db->showOne($contentid);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'pages' => $pages,
            'contentitemtitle' => $content->getContentItemTitle(),
            'contentitem' => $content->getContentItem(),
            'created' => $content->getCreated(),
            'contentid' => $content->getContentId()
            );

        $templateName = 'admin/singleContent';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }


    public function createContentFormAction(Request $request, Application $app)
    {
        $user = ;
        $db = new DbRepository($app['dbh']);
        $pages = $db->getAllPages();

        $args_array = array(
            'pages' => $pages,
            'user' => $app['session']->get('user')
        );

        $templateName = 'admin/contentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
    public function processContentAction(Request $request, Application $app)
    {
        $pagename = $app['request']->get('pagename');
        $contenttype = $app['request']->get('contenttype');
        $contentitemtitle = $app['request']->get('contentitemtitle');
        $contentitem = $app['request']->get('contentitem');
        $db = new DbRepository($app['dbh']);
        $app['monolog']->addInfo('You just connected to the database');
        $pages = $db->getAllPages();
        $result = $db->createContent($pagename, $contenttype, $contentitemtitle, $contentitem);

        $args_array = array(
            'user' => $app['session']->get('user'),
            'pages' => $pages,
            'result' => $result
            );

        $templateName = 'admin/dashboard';

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

        $templateName = 'admin/deleteContentForm';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }

    public function processDeleteContentAction(Request $request, Application $app, $contentid)
    {
        $db = new DbRepository($app['dbh']);
        $result = $db->deleteContent($contentid);
        $pages = $db->getAllPages();
        $content = $db->getAllPagesContent();

        $args_array = array(
            'user' => $app['session']->get('user'),
            'content' => $content,
            'pages' => $pages,
            'result' => $result
            );

        $templateName = 'admin/content';

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

        $templateName = 'admin/editContentForm';

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

        $templateName = 'admin/dashboard';

        return $app['twig']->render($templateName.'.html.twig', $args_array);
    }
}
