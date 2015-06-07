<?php
use Igorw\Silex\ConfigServiceProvider;
use Silex\Application;
use Silex\Provider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;

// Create the application to run.
$app = new Application();

$app->register(new Provider\SecurityServiceProvider());
$app->register(new Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/CMS/views',
));
$app->register(new ConfigServiceProvider(__DIR__ . "/../etc/configuration.yml.dist"));
if (is_readable(__DIR__ . "/../etc/configuration.yml")) {
	$app->register(new ConfigServiceProvider(__DIR__ . "/../etc/configuration.yml"));
}

if (isset($app['database.driver']) && isset($app['database.dbname']) &&
	isset($app['database.host']) && isset($app['database.user']) &&
	isset($app['database.password']) && isset($app['database.charset'])) {
	$app->register(new Silex\Provider\DoctrineServiceProvider(), [
		'db.options' => [
			'driver' => $app['database.driver'],
			'dbname' => $app['database.dbname'],
			'host' => $app['database.host'],
			'user' => $app['database.user'],
			'password' => $app['database.password'],
			'charset' => $app['database.charset']
		]
	]);
}

$app->register(new SimpleUser\UserServiceProvider());

// The route configuration is stored in Yaml files.
$app["routes"] = $app->extend("routes", function (RouteCollection $routes) {
	$loader = new YamlFileLoader(new FileLocator(__DIR__ . "/../etc/routes/"));
	$collection = $loader->load("routes.cms.yml");
	$routes->addCollection($collection);
	return $routes;
});

return $app;