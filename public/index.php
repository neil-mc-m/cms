<?php
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________
use CMS\DbManager;
use CMS\DbRepository;
use CMS\DatabaseTwigLoader;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

require_once __DIR__.'/../vendor/autoload.php';
# parse the config file 
$config = parse_ini_file('../config/config.ini', true);
# get the theme and add it to the twig loaders path.
$myTemplatesPath1 = __DIR__.'/../themes/'.$config['themes']['theme'].'/templates';
$myTemplatesPath2 = __DIR__.'/../templates/admin';
$loggerPath = dirname(__DIR__).'/logs';
$app = new Silex\Application();



$app['title'] = '';
if (isset($config['title']['title'])) {
    $app['title'] = $config['title']['title'];
}

$app['image'] = '';
if (isset($config['bg-image']['image'])) {
    $app['image'] = '/images/'.$config['bg-image']['image']; 
}




# store regularly used variables(services?) in the app container
$dbmanager = new DbManager();
# app['dbh'] is a connection instance and is passed to the constructor
# of the database repository. 
$app['dbh'] = $dbmanager->getPdoInstance();
$db = new DbRepository($app['dbh']);
# The $pages variable will be accessible in twig templates as app.pages.
# and will (usually) be an array of page objects
# so you can loop through with a twig for loop. 
# e.g {% for page in app.pages %}{{ page.pageName or page.pageTemplate }}
# this will save having to query the database every time you want to access 
# the page objects. 
$app['pages'] = $db->getAllPages();
$app['images'] = $db->viewImages();
# twig loaders for templates: a database loader for dynamically created templates,
# and a filesystem loader for templates stored on the filesystem. 
$app['loader1']  = new DatabaseTwigLoader($app['dbh']);
$app['loader2'] = new Twig_Loader_Filesystem(array($myTemplatesPath1, $myTemplatesPath2));
$app['debug'] = true;
# ______________________________________________________________
#              ADD PROVIDERS HERE
# ______________________________________________________________
#
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    #'twig.path' => array($myTemplatesPath1, $myTemplatesPath2),
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
),));
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $loggerPath .'/development.log'
));;
# an extension to add a paragraphing filter to twig templates.
# see https://github.com/jasny/twig-extensions. 
$app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
    $twig->addExtension(new Jasny\Twig\TextExtension());

    return $twig;
}));
# ________________________________________________________________
#                      ROUTES
# ________________________________________________________________
#
$app->get('/', 'CMS\\Controllers\\MainController::indexAction');

$app->get('/login', 'CMS\\Controllers\\SecurityController::logInAction');
$app->get('/search/{q}', 'CMS\\Controllers\\SearchController::searchAction');
$app->get('/{pageRoute}', 'CMS\\Controllers\\MainController::routeAction');


$app->get('/articles', 'CMS\\Controllers\\MainController::articlesAction');
$app->get('/articles/{id}', 'CMS\\Controllers\\MainController::oneArticleAction');


$app->get('/admin/logout', 'CMS\\Controllers\\SecurityController::logoutAction');

$app->get('/admin/dashboard', 'CMS\\Controllers\\AdminController::dashboardAction');

$app->get('/admin/pages', 'CMS\\Controllers\\PagesController::pagesAction');
$app->get('/admin/view-pages', 'CMS\\Controllers\\PagesController::viewPagesAction');

$app->get('/admin/create-page', 'CMS\\Controllers\\PagesController::createPageAction');
$app->post('/admin/new-page', 'CMS\\Controllers\\PagesController::newPageAction');

$app->get('/admin/delete-page', 'CMS\\Controllers\\PagesController::deletePageAction');
$app->post('/admin/process-delete-page', 'CMS\\Controllers\\PagesController::processDeletePageAction');

$app->get('/admin/view-content', 'CMS\\Controllers\\ContentController::contentAction');
$app->get('/admin/view-single-content/{contentId}', 'CMS\\Controllers\\ContentController::singleContentAction');

$app->get('/admin/create-content', 'CMS\\Controllers\\ContentController::createContentFormAction');
$app->post('/admin/process-content', 'CMS\\Controllers\\ContentController::processContentAction');

$app->get('/admin/delete-content', 'CMS\\Controllers\\ContentController::deleteContentFormAction');
$app->get('/admin/process-delete-content/{contentid}', 'CMS\\Controllers\\ContentController::processDeleteContentAction');

$app->get('/admin/edit-content/{contentId}', 'CMS\\Controllers\\ContentController::editContentAction');
$app->post('/admin/process-edit-content', 'CMS\\Controllers\\ContentController::processEditContentAction');



$app->get('/admin/images', 'CMS\\Controllers\\ImageController::viewImagesAction');
$app->post('/admin/add-image', 'CMS\\Controllers\\ImageController::addImageAction');
$app->get('/admin/upload-image', 'CMS\\Controllers\\ImageController::uploadImageFormAction');
$app->post('admin/process-imageUpload', 'CMS\\Controllers\\ImageController::processImageUploadAction');


$app->get('/{pageRoute}/{contentId}', 'CMS\\Controllers\\MainController::oneArticleAction');
$app->run();
