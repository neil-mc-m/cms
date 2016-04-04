<?php
namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;


class ImageController
{
	public function viewImagesAction(Request $request, Application $app)
	{
		$db = new DbRepository($app['dbh']);
		$images = $db->viewImages();
		$content = $db->getAllPagesContent();
		var_dump($images);
		var_dump($content);
		$args_array = array(
			'user' => $app['session']->get('user'),
			'images' => $images,
			'content' => $content
			);

		$templateName = '_viewImages';

		return $app['twig']->render($templateName.'.html.twig', $args_array);
	}

	public function addImageAction(Request $request, Application $app)
	{
		$db = new DbRepository($app['dbh']);
		$contentId = $app['request']->get('contentId');
		$imagePath = $app['request']->get('imagePath');
		var_dump($contentId);
		var_dump($imagePath);
		$result = $db->addImage($imagePath, $contentId);
		$content = $db->showOne($contentId);

		$args_array = array(
			'user' => $app['session']->get('user'),
			'image' => $content->getImagePath(),
			'contentitemtitle' => $content->getContentItemTitle(),
            'contentitem' => $content->getContentItem(),
            'created' => $content->getCreated(),
            'contentid' => $content->getContentId(),
            'result' => $result
			);
		$templateName = 'singleContent';

		return $app['twig']->render($templateName.'.html.twig', $args_array);
	}
}
