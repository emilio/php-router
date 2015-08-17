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

    /**
     * @runInSeparateProcess
     */
    public function testRedirect()
    {
        $_SERVER['REQUEST_URI'] = '/redirect_test';
        $_SERVER['REQUEST_METHOD'] = 'GET';

        $router = new Router();

        $router->redirect('/redirect_test', '/redirected', 301);

        $router->route();

        $this->assertTrue(http_response_code() === 301);

        $headers = xdebug_get_headers();

        $location_header_found = false;
        foreach ($headers as $header) {
            if (strpos($header, 'Location:') !== false) {
                $location_header_found = true;
                $this->assertTrue(strpos($header, '/redirected') !== false);
            }
        }

        $this->assertTrue($location_header_found);
    }
}
