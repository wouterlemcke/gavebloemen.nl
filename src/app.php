<?php
use Silex\Application;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\YamlFileLoader;
use Symfony\Component\Routing\RouteCollection;
// Create the application to run.
$app = new Application();

// The route configuration is stored in Yaml files.
$app["routes"] = $app->extend("routes", function (RouteCollection $routes) {
	$loader = new YamlFileLoader(new FileLocator(__DIR__ . "/../etc/routes/"));
	$collection = $loader->load("routes.yml");
	$routes->addCollection($collection);
	return $routes;
});

return $app;