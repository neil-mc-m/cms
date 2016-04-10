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
 * 
 */ 
class ImageController
{
	/**
	 * A route to retrieve images from the database and present 
	 * them to the user for adding to content
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
			'content' => $content
			);

		$templateName = '_viewImages';

		return $app['twig']->render($templateName.'.html.twig', $args_array);
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
            'result' => $result
			);
		$templateName = '_singleContent';

		return $app['twig']->render($templateName.'.html.twig', $args_array);
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

		return $app['twig']->render($templateName.'.html.twig', $args_array);
	}

	/**
	 * A controller for processing the upload images form.
	 * Validations: a jpg or png, under 1M and file must not already exist.
	 * The image path will be stored in the db.
	 * 
	 * @param request object
	 * @param app object
	 * 
	 * @return twig template
	 */ 
	public function processImageUploadAction(Request $request, Application $app)
	{
		
		# image upload code..[ adapted from www.w3schools.com and www.davidwalsh.com image upload code ]
		# Also uses the symfony validator service to check the file type. 
        # $_FILES['photo']['$var'] -- this holds 4 varaiables::'name','size','tmp_name','error' (image is the name on the html form)
        # Sets a validation variable - $uploadOk -. 
        # This needs to be true at the end of validation for the upload to proceed.
        $uploadOk = false;
        $message = '';
        if (!$_FILES['image']['error']) {
        	$uploadOk = true;
        } elseif ($_FILES['image']['error']) {
        	$message .= 'There was a problem with the upload. Check the following : 1. The image should be a .jpg or a .png.'.'<br>'.'2. The image is under 1 Megabyte.';
        	$uploadOk = false;
        }
        $constraint = new Assert\Image(array(
        	'mimeTypes' => array('image/jpeg','image/png')
        	));
        
        $errors = $app['validator']->validate($_FILES['image']['tmp_name'], $constraint);
        if (count($errors) > 0) {
        	foreach ($errors as $error) {
            	$message .= $error->getPropertyPath().' '.$error->getMessage()."\n";	
        	} 
        	$uploadOk = false;
        } 
        if (file_exists($request->getBasePath().'images/' . $_FILES['image']['name'])) {
    		$message .= "Sorry, file already exists.";
    		$uploadOk = false;
		}
       
        # var_dump($uploadOk);
        # if the validation variable is false, re-render the upload form with an error message
        if ($uploadOk == false) {
           		$args_array = array(
				'user' => $app['session']->get('user'),
				'result' => $message
			);
			$templateName = '_uploadImageForm';

			return $app['twig']->render($templateName.'.html.twig', $args_array);

        } 
        else {

         move_uploaded_file($_FILES['image']['tmp_name'], $request->getBasePath().'images/' . $_FILES['image']['name']);
            $path = $_FILES['image']['name'];
        	$newImage = new Image();
        	$newImage->setImagePath($path);
       		$image = $newImage->getImagePath();
        	$db = new DbRepository($app['dbh']);
        	$result = $db->uploadImage($image);
        	$images = $db->viewImages();
			$content = $db->getAllPagesContent();
        	$args_array = array(
				'user' => $app['session']->get('user'),
				'result' => $result,
				'images' => $images,
				'content' => $content	
				);
			$templateName = '_viewImages';

			return $app['twig']->render($templateName.'.html.twig', $args_array);
        }

	}
}
