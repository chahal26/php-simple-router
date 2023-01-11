<?php
namespace Chahal26\PhpSimpleRouter;

Class Router 
{
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
}