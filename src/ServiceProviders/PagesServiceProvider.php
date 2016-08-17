<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 17/08/2016
 * Time: 23:47
 */

namespace CMS\ServiceProviders;

use Silex\Application;
use Silex\ServiceProviderInterface;

class PagesServiceProvider implements ServiceProviderInterface
{
    public function register(Application $app)
    {
        $app['pages'] = function () use ($app) {
            return $app['dbrepo']->getAllPages();
        };
    }

    public function boot(Application $app)
    {

    }
}