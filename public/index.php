<?php
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________

require_once __DIR__.'/../vendor/autoload.php';
$myTemplatesPath = __DIR__.'/../templates';
$loader = new Twig_Loader_Filesystem($myTemplatesPath);
$app = new Silex\Application();
$app['debug'] = true;
# ______________________________________________________________
#              ADD PROVIDERS HERE
# ______________________________________________________________
#

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath, ));
// $app->register(new Silex\Provider\SecurityServiceProvider(), array(
//         'security.firewalls' => array('admin' => array(
//                 'pattern' => '^/admin',
//                 'http' => true,
//                 'users' => array(
//                     // raw password is foo
//                     'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==')
//                 )
//     ),),));

# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'LightCMS\\MainController::indexAction');
$app->get('/{page}', 'LightCMS\\MainController::routeAction');
$app->get('/articles', 'LightCMS\\MainController::articlesAction');
$app->get('/articles/{id}', 'LightCMS\\MainController::oneArticleAction');
$app->run();
