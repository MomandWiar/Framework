<?php

namespace Wiar\Core;

class Router
{
    /**
     * All registered routes.
     *
     * @var array
     */
	protected $routes = [
		'GET' => [],
		'POST' => []
	];

    /**
     * Load a user's routes file.
     *
     * @param string $file
     * @return static
     */
	public static function load($file)
	{
		$router = new static;

		require $file;

		return $router;
	}

    /**
     * Register a GET route.
     *
     * @param string $uri
     * @param string $controller
     */
	public function get($uri, $controller)
	{
		$this->routes['GET'][$uri] = $controller;
	}

    /**
     * Register a POST route.
     *
     * @param string $uri
     * @param string $controller
     */
	public function post($uri, $controller)
	{
		$this->routes['POST'][$uri] = $controller;
	}

    /**
     * Load the requested URI's associated controller method.
     *
     * @param string $uri
     * @param string $requestType
     * @return mixed
     */
	public function direct($uri, $requestType)
	{
		if (array_key_exists($uri, $this->routes[$requestType])) {
			return $this->callAction(
				...explode('@', $this->routes[$requestType][$uri])
			);
		}

		throw new Exception('No route defined for this URI.');
	}

    /**
     * Load and call the relevant controller action.
     *
     * @param string $controller
     * @param string $action
     * @return mixed
     */
	protected function callAction($controller, $action)
	{
		$controller = "Wiar\\Controllers\\{$controller}";
		$controller = new $controller;

		if(! method_exists($controller, $action)) {
			throw new Exception(
				"{$controller} does not repond to the {$action} action."
			);
		}

		return $controller->$action();
	}
}