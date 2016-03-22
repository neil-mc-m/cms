<?php
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________
use CMS\DbManager;
use CMS\DatabaseTwigLoader;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

require_once __DIR__.'/../vendor/autoload.php';
$myTemplatesPath = __DIR__.'/../templates';
$loggerPath = dirname(__DIR__).'/logs';



$app = new Silex\Application();
$dbmanager = new DbManager();
$app['dbh'] = $dbmanager->getPdoInstance();
$app['loader1']  = new DatabaseTwigLoader($app['dbh']);
$app['loader2'] = new Twig_Loader_Filesystem($myTemplatesPath);
# $app['loader'] = new Twig_Loader_Chain(array($loader1, $loader2));


$app['debug'] = true;


# ______________________________________________________________
#              ADD PROVIDERS HERE
# ______________________________________________________________
#

$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => $myTemplatesPath,
    'twig.loader' => $app->share(function()use($app){
        return new Twig_Loader_Chain(array($app['loader1'], $app['loader2']));
        })));
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
),

));


$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $loggerPath .'/development.log'
));
;
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'CMS\\controllers\\MainController::indexAction');
#$app->get('/admin', 'CMS\\controllers\\SecurityController::logInAction');
$app->get('/login', 'CMS\\controllers\\SecurityController::logInAction');
$app->get('/{page}', 'CMS\\controllers\\MainController::routeAction');


$app->get('/articles', 'CMS\\controllers\\MainController::articlesAction');
$app->get('/articles/{id}', 'CMS\\controllers\\MainController::oneArticleAction');

#$app->post('/admin/login_check', 'CMS\\controllers\\SecurityController::loginCheckAction');
$app->get('/admin/logout', 'CMS\\controllers\\SecurityController::logoutAction');

$app->get('/admin/dashboard', 'CMS\\controllers\\AdminController::dashboardAction');
$app->get('/admin/analytics', 'CMS\\controllers\\AdminController::analyticsAction');

$app->get('/admin/pages', 'CMS\\controllers\\PagesController::pagesAction');
$app->get('/admin/view-pages', 'CMS\\controllers\\PagesController::viewPagesAction');
$app->get('/admin/create-page', 'CMS\\controllers\\PagesController::createPageAction');
$app->post('/admin/new-page', 'CMS\\controllers\\PagesController::newPageAction');
$app->get('/admin/delete-page', 'CMS\\controllers\\PagesController::deletePageAction');
$app->post('/admin/process-delete-page', 'CMS\\controllers\\PagesController::processDeletePageAction');

$app->get('/admin/content', 'CMS\\controllers\\ContentController::contentAction');
$app->get('/admin/create-content', 'CMS\\controllers\\ContentController::createContentFormAction');
$app->post('/admin/process-content', 'CMS\\controllers\\ContentController::processContentAction');
$app->get('/admin/delete-content', 'CMS\\controllers\\ContentController::deleteContentFormAction');
$app->get('/admin/process-delete-content/{id}', 'CMS\\controllers\\ContentController::processDeleteContentAction');
$app->get('/{page}/{contentid}', 'CMS\\controllers\\MainController::oneArticleAction');

$app->run();
