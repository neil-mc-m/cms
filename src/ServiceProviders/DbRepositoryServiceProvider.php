<?php

namespace CMS\ServiceProviders;

use CMS\DbRepository;
use Silex\Application;
use Silex\ServiceProviderInterface;

class DbRepositoryServiceProvider implements ServiceProviderInterface {
	public function register(Application $app)
    {
		$app['dbrepo'] = function () use ($app) {
			return new DbRepository($app['db']);
		};
	}
	public function boot(Application $app)
    {

    }
}
