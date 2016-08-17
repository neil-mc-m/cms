<?php
/**
 * Created by PhpStorm.
 * User: neil
 * Date: 14/08/2016
 * Time: 22:05
 */
# _______________________________________________________________
#                    SETUP
# _______________________________________________________________
use CMS\CustomUserProvider;
use CMS\DatabaseTwigLoader;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;

require_once __DIR__ . '/../vendor/autoload.php';
# parse the config file
$config = parse_ini_file(realpath('../config/config.ini'), true);
# get the theme and add it to the twig loaders path.
$myTemplatesPath1 = __DIR__ . '/../themes/' . $config['themes']['theme'] . '/templates';
$myTemplatesPath2 = __DIR__ . '/../templates/admin';
$loggerPath = dirname(__DIR__).'/logs';
$app = new Silex\Application();

$app['title'] = '';
if (isset($config['title']['title'])) {
	$app['title'] = $config['title']['title'];
}

$app['image'] = '';
if (isset($config['bg-image']['image'])) {
	$app['image'] = '/images/' . $config['bg-image']['image'];
}

# The $pages variable will be accessible in twig templates as app.pages.
# and will (usually) be an array of page objects
# so you can loop through with a twig for loop.
# e.g {% for page in app.pages %}{{ page.pageName or page.pageTemplate }}
# this will save having to query the database every time you want to access
# the page objects.
# twig loaders for templates: a database loader for dynamically created templates,
# and a filesystem loader for templates stored on the filesystem.

$app['debug'] = true;
# ______________________________________________________________
#              ADD PROVIDERS HERE
# ______________________________________________________________
#
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => $config['database']
    ));
$app->register(new CMS\ServiceProviders\DbRepositoryServiceProvider());
$app->register(new CMS\ServiceProviders\PagesServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app['loader1'] = new Twig_Loader_Filesystem(array($myTemplatesPath1, $myTemplatesPath2));
$app['loader2'] = new DatabaseTwigLoader($app['db']);
$app->register(new Silex\Provider\TwigServiceProvider(), array(
	'twig.loader' => $app->share(function () use ($app) {
		return new Twig_Loader_Chain(array($app['loader1'], $app['loader2']));
	})));
$app->register(new Silex\Provider\SecurityServiceProvider(), array(
	'security.firewalls' => array(

		'admin' => array(
			'pattern' => '^/admin',
			'form' => array('login_path' => '/login', 'check_path' => '/admin/login_check', 'username_parameter' => '_username', 'password_parameter' => '_password'),
			'logout' => array('logout_path' => '/admin/logout', 'invalidate_session' => true),
			'users' => $app->share(function () use ($app) {
				return new CustomUserProvider($app['db']);
			}),
		),
	),
));
$app['security.encoder.digest'] = $app->share(function ($app) {
	// use the sha1 algorithm
	// don't base64 encode the password
	// use only 1 iteration
	return new MessageDigestPasswordEncoder('sha1', false, 1);
});
# uncomment the logger while developing
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => $loggerPath.'/development.log',
));
# an extension to add a paragraphing filter to twig templates.
# see https://github.com/jasny/twig-extensions.
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
	$twig->addExtension(new Jasny\Twig\TextExtension());

	return $twig;
}));
$app['twig'] = $app->share($app->extend('twig', function ($twig, $app) {
	$twig->addFilter(new \Twig_SimpleFilter('code', function ($string, $language) {
		return str_replace(array('<code>', '</code>'), array('<pre><code class="language-' . $language . '">', '</code></pre>'), $string);
	}, array('is_safe' => array('html'))));

	return $twig;
}));
# set up a custom error page to handle exceptions and errors.
$app->error(function (\Exception $e, $code) use ($app) {
	return new Response($app['twig']->render('error.html.twig'));
});
return $app;