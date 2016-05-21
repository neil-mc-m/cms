<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 19/05/2016
 * Time: 00:35
 */

namespace CMS;

use Silex\Application;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\Request;
/**
 * Class Upload
 *
 * Handle file uploads.
 *
 * @package CMS
 */
class Upload
{
    /**
     * @var app
     * the app var needs to be available for the validator service to work.
     */
    public $app;
    /**
     * @var file
     * uploaded file 
     */

    
    /**
     * @var validfile flag yes or no. set to false. true on success.
     */
    public $validfile = false;
    
    
    public $message = '';
    
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function checks($file, Application $app)
    {

        $constraint = new Assert\Image(array(
            'mimeTypes' => array('image/jpeg', 'image/png'),
            'maxSize' => '2M'
        ));

        $errors = $app['validator']->validate($file, $constraint);
            if (count($errors) > 0) {
                foreach ($errors as $error) {
                    $this->message = $error->getPropertyPath() . ' ' . $error->getMessage() . "\n";
                }
                $this->validfile = false;
            }
            if (file_exists($request->getBasePath() . 'images/' . $request->files->get('image[originalName]'))) {
                $this->message = 'Sorry, file already exists';
                $this->validfile = false;
            } 
        return array($this->validfile, $this->message);
        
    }
}