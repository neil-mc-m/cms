<?php

namespace CMS;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class DbRepoServiceProvider implements ServiceProviderInterface {
	public function register(Container $app) {
		$app['dbrepo'] = function () use ($app) {
			return new DbRepository($app['db']);
		};
	}
}