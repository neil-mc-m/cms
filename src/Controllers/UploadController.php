<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 19/05/2016
 * Time: 00:35
 */

namespace CMS\Controllers;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
use CMS\DbRepository;
use CMS\Image;
/**
 * Class Upload
 *
 * Handle file uploads.
 *
 * @package CMS
 */
class UploadController
{
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
        $file = $request->files->get('image');
        $pic = $file->getClientOriginalName();
        $constraint = new Assert\Image(array(
            'mimeTypes' => array('image/jpeg', 'image/png'),
            'maxSize' => '2M'
        ));
        $validfile = true;
        $message = '';
        $errors = $app['validator']->validate($file, $constraint);
        if (count($errors) > 0) {
            foreach ($errors as $error) {
                $message = $error->getPropertyPath() . ' ' . $error->getMessage() . "\n";
            }
            $validfile = false;
        }
        if (file_exists($request->getBasePath() . 'images/' . $file->getClientOriginalName())) {
            $message = 'Sorry, file already exists';
            $validfile = false;
        }
        # if the validation variable is false, re-render the upload form with an error message
        if ($validfile == false) {
            $args_array = array(
                'user' => $app['session']->get('user'),
                'result' => $message,
            );
            $templateName = '_uploadImageForm';

            return $app['twig']->render($templateName . '.html.twig', $args_array);
        } elseif ($validfile == true) {
            $file->move($request->getBasePath() . 'images/' ,$file->getClientOriginalName());
            $path = $file->getClientOriginalName();
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
                'content' => $content,
            );
            $templateName = '_viewImages';

            return $app['twig']->render($templateName . '.html.twig', $args_array);
        }
    }
}