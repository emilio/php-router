<?php
namespace Tests;

use \Router\Router;
use \Router\Route;
use \Router\RouteNotFoundException;

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testRouteExceptionKind()
    {
        $_SERVER['REQUEST_URI'] = '/hello';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $router = new Router();

        $router->all('/test_not_found', function () {

        });

        try {
            $router->route();
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof RouteNotFoundException);
        }
    }

    public function testRouteExample()
    {
        $_SERVER['REQUEST_URI'] = '/hello';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('pass');

        $router = new Router();

        $router->all('/hello', function () {
            echo 'pass';
        });

        try {
            $router->route();
        } catch (RouteNotFoundException $e) {
            $this->assertTrue(false);
        }
    }

    public function testRouteParam()
    {
        $_SERVER['REQUEST_URI'] = '/post/123';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $this->expectOutputString('pass 123');

        $router = new Router();
        $router->all('/post/([0-9]+)', function ($param) {
            echo "pass {$param}";
        });

        try {
            $router->route();
        } catch (RouteNotFoundException $e) {
            $this->assertTrue(false);
        }
    }
}
