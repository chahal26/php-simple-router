<?php
    require_once 'vendor/autoload.php';
   
    use Chahal26\PhpSimpleRouter\Router;

    /* Creating Route Instance */
    $router = new Router();

    /* Defining Routes */
    $router->get('/', function(){
        echo "<h1>Welcome To Home Page</h1>";
    });

    $router->get('/about', '\App\Controllers\PagesController@about');
    $router->get('register', function(){
        echo "<h1>Welcome To Register Page</h1>";
    });
    $router->post('login', function(){
        echo "Login Page";
    });

    /* Execute Routes */
    $router->run();
