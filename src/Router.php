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

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->current_uri = $this->getCurrentUri();
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
    }

    /**
     * Collects all routes in an array
     */
    public function getRoutesArray($methods, $route, $fn):void
    {
        $methods = $methods ?? $this->available_methods;

        foreach ($methods as $method) {
            $this->available_routes[$method][] = [
                'route' => $route,
                'fn' => $fn,
            ]; 
        }
    }

}