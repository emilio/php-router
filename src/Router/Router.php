<?php
namespace Router;

class Router
{
    /** Base url */
    private $base_path;

    /** Current relative url */
    private $path;

    /**
     * @var Route[]
     */
    public $routes = array();

    /**
     * Constructor
     * @param string $base_path the index url
     */
    public function __construct($base_path = '')
    {
        $this->base_path = $base_path;
        $path = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        $path = substr($path, strlen($base_path));
        $this->path = $path;
    }

    /**
     * Add a route
     * @param string $expr
     * @param mixed $callback
     * @param array|string $methods
     * @return void
     */
    public function all($expr, $callback, $methods = null)
    {
        $this->routes[] = new Route($expr, $callback, $methods);
    }

    /**
     * Alias for all
     * @param string $expr
     * @param mixed $callback
     * @param null|array $methods
     */
    public function add($expr, $callback, $methods = null)
    {
        $this->all($expr, $callback, $methods);
    }

    /**
     * Add a route for GET requests
     * @param string $expr
     * @param mixed $callback
     */
    public function get($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'GET');
    }

    /**
     * Add a route for POST requests
     * @param string $expr
     * @param mixed $callback
     */
    public function post($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'POST');
    }

    /**
     * Add a route for HEAD requests
     * @param string $expr
     * @param mixed $callback
     */
    public function head($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'HEAD');
    }

    /**
     * Add a route for PUT requests
     * @param string $expr
     * @param mixed $callback
     */
    public function put($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'PUT');
    }

    /**
     * Add a route for DELETE requests
     * @param string $expr
     * @param mixed $callback
     */
    public function delete($expr, $callback)
    {
        $this->routes[] = new Route($expr, $callback, 'DELETE');
    }

    /**
     * Test all routes until any of them matches
     */
    public function route()
    {
        foreach ($this->routes as $route) {
            if ($route->matches($this->path)) {
                return $route->exec();
            }
        }

        throw new \Exception("No routes matching {$this->path}");
    }

    /**
     * Get the current url or the url to a path
     * @param string $path
     * @return string
     */
    public function url($path = null)
    {
        if ($path === null) {
            $path = $this->path;
        }

        return $this->base_path . $path;
    }
}
