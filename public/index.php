<?php
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________
use LightCMS\DbManager;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

require_once __DIR__.'/../vendor/autoload.php';
$myTemplatesPath = __DIR__.'/../templates';
$loggerPath = dirname(__DIR__).'/logs';


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
    'twig.path' => $myTemplatesPath ));
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
        'security.firewalls' => array(
            'admin' => array(
                'pattern' => '^/admin',
                'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check', 'username_parameter' => '_username', 'password_parameter' => '_password'),
                'logout' => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
                'users' => array(
                    'admin' => array('ROLE_ADMIN', '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==')
        ),
    ),
),));


$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $loggerPath .'/development.log'
));
;
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'LightCMS\\controllers\\MainController::indexAction');
#$app->get('/admin', 'LightCMS\\controllers\\SecurityController::logInAction');
$app->get('/login', 'LightCMS\\controllers\\SecurityController::logInAction');
$app->get('/{page}', 'LightCMS\\controllers\\MainController::routeAction');
$app->get('/articles', 'LightCMS\\controllers\\MainController::articlesAction');
$app->get('/articles/{id}', 'LightCMS\\controllers\\MainController::oneArticleAction');

#$app->post('/admin/login_check', 'LightCMS\\controllers\\SecurityController::loginCheckAction');
$app->get('/admin/logout', 'LightCMS\\controllers\\SecurityController::logoutAction');
$app->get('/admin/dashboard', 'LightCMS\\controllers\\AdminController::dashboardAction');

$app->run();
