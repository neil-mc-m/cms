<?php
namespace CMS\Controllers;

use Silex\Application;
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
        
        # $_FILES['photo']['$var'] -- this holds 4 varaiables::'name','size','tmp_name','error' (image is the name on the html form)
        $valid_file = false;
        if ($_FILES['image']['name']) {
            //if no errors...
            if (!$_FILES['image']['error']) {
                // validate the file
                $valid_file = true;
                if ($_FILES['image']['size'] > (1024000)) { //can't be larger than 1 MB
    				$valid_file = false;
                }

                if (!$size = getimagesize($_FILES['image']['name'])) {
                	$valid_types = array(IMAGETYPE_JPEG, IMAGETYPE_PNG);
                	if(in_array($size[2],  $valid_types)) {
        				$valid_file = true;
    				} else {
       				 $valid_file = false;
   					 }
                	$valid_file = false;
                }
                if ($valid_file == true) {
                    //move it to the images folder
                    move_uploaded_file($_FILES['image']['tmp_name'], $request->getBasePath().'images/' . $_FILES['image']['name']);
                }
            } //if there is an error
            else {
                //set that to be the returned message
                $answer = 'Ooops!  Your upload triggered the following error:  ' . $_FILES['image']['error'];
                print $answer;
            }
        }
        // assign the name of the uploaded image to a variable
        $path = $_FILES['image']['name'];
        // create a new product object and set the image as the uploaded image name
        // e.g carrot_salad.jpg . The set method will create a string that will correspond
        // to an image path . Then the getImage() method will return the path for the insert
        // statement that is used by the createProduct method in the model.
        // Finally, the selectAll() method will select all products from the database
        // in which the new image can be seen for the new product.
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
