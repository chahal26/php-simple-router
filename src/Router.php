<?php
namespace Chahal26\PhpSimpleRouter;

Class Router 
{
    /**
     * Current URI
     */
    private string $current_uri;

    private array $available_routes;

    private array $available_methods = ['GET', 'POST'];

    private string $namespace = '';

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->current_uri = $this->getCurrentUri();
    }

    /**
     * Get Current Request Method
     */
    public function getCurrentRequestMethod():string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * Sets Namespace for all routes
     */
    public function setNamespace(string $namespace):void
    {
        $this->namespace = $namespace;
    }

    /**
     * Get Current Request URI
     */
    public function getCurrentUri():string
    {
        $request_uri = rawurldecode($_SERVER['REQUEST_URI']);
        $uri = substr($request_uri, strlen(implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/'));

        if (strstr($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        $uri = '/'. trim($uri, '/');

        return $uri;
    }

    /**
     * For executing the function
     */
    public function execute($fn, $params = []): void
    {
        if(is_callable($fn)){
            call_user_func_array($fn, $params);
            return;
        }
        
        if(strpos( $fn, '@')){
            list($controller, $method) = explode('@', $fn);

            if($this->namespace !== '')
            {
                $controller = $this->namespace.'\\'.$controller;
            }

            $instance = new $controller();
            call_user_func_array(array($instance, $method), $params);
            return;
        }

    }

    /**
     * Collects all routes in an array
     */
    public function addToRoutesArray($methods, $route, $fn):void
    {
        $methods = $methods ?? $this->available_methods;
        $route = '/'.trim($route, '/');

        foreach ($methods as $method) {
            $this->available_routes[$method][$route] = $fn; 
        }
    }

    /**
     * Accepts GET method only
     */
    public function get($route, $fn):void
    {
        $this->addToRoutesArray(['GET'], $route, $fn);
    }

    /**
     * Accepts POST method only
     */
    public function post($route, $fn):void
    {
        $this->addToRoutesArray(['POST'], $route, $fn);
    }

    /**
     * To Check if same pattern exists
     */
    protected function checkIfPatternExists($route): bool
    {
        if($route === $this->current_uri)
        {
            return true;
        }

        return false;
    }

    /**
     * Runs the required route after checking 
     */
    public function run():void
    {   
        $routesMatched = 0;
        
        foreach ($this->available_routes as $method => $routeArray) {
            if($method === $this->getCurrentRequestMethod()){
                foreach ($routeArray as $route => $fn)
                {
                    if($this->checkIfPatternExists($route))
                    {
                        $this->execute($fn);
                        $routesMatched ++;
                        break;
                    }
                }
                
            }
        }

        if($routesMatched === 0)
        {
            header("HTTP/1.0 404 Not Found");
        }
    }
}