# chahal26/php-simple-router

A simple & lightweight PHP Router made with Object Oriented PHP.
Built with :heart: by [Sahil Chahal](https://github.com/chahal26)

It currently supports static routes only.

## Prerequisites/Requirements

- PHP >= 8.0
- [URL Rewriting](https://gist.github.com/chahal26/b6233a6e6a93321c6eae0a05ba9954b5)

## Usage

Create an instance of `\Chahal26\PhpSimpleRouter\Router`, define some routes, and run it.

```php
    require_once 'vendor/autoload.php';

    use Chahal26\PhpSimpleRouter\Router;

    /* Creating Route Instance */
    $router = new Router();

    /* Defining Routes */


    /* Execute Routes */
    $router->run();
```

## Available Routing Methods

- GET
- POST

## Defining Routes

```php
$router->get('route', function() { /* ... */ });
$router->post('route', function() { /* ... */ });
```

## Example

```php
    $router->get('/', function(){
        echo "<h1>Welcome To Home Page</h1>";
    });

    $router->get('/contact', function(){
        echo "<h1>Welcome To Contact Page</h1>";
    });
```
