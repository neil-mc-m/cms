<?php
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________
use Silex\Provider;
require_once __DIR__.'/../vendor/autoload.php';
$myTemplatesPath = __DIR__.'/../templates';
$loader = new Twig_Loader_Filesystem($myTemplatesPath);
$app = new Silex\Application();
$app['debug'] = true;
# ______________________________________________________________
#              ADD PROVIDERS HERE
# ______________________________________________________________
#
$app->register(new Provider\HttpFragmentServiceProvider());
$app->register(new Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.path' => $myTemplatesPath));
$app->register(new Provider\WebProfilerServiceProvider(), array(
    'profiler.cache_dir' => __DIR__.'/../cache/profiler',
    'profiler.mount_prefix' => '/_profiler', // this is the default
));
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/home', 'LightCMS\\MainController::indexAction');
$app->run();
