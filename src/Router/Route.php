<?php
namespace Router;

class Route
{
    /** The regular expresion */
    private $expr;
    /** The callback function */
    private $callback;
    /** The matches of $expr */
    private $matches;
    /** Allowed methods for this route */
    private $methods = array('GET', 'POST', 'HEAD', 'PUT', 'DELETE');

    /**
     * Constructor
     * @param string $expr regular expresion to test against
     * @param function $callback function executed if route matches
     * @param string|array $methods methods allowed
     */
    public function __construct($expr, $callback, $methods = null) {
        // Allow an optional trailing backslash
        $this->expr = '#^' . $expr . '/?$#';
        $this->callback = $callback;

        if ($methods !== null)
            $this->methods = is_array($methods) ? $methods : array($methods);
    }

    /**
     * See if route matches with path
     * @param string $path
     * @return boolean
     */
    public function matches($path) {
        if (preg_match($this->expr, $path, $this->matches) &&
            in_array($_SERVER['REQUEST_METHOD'], $this->methods))
            return true;

        return false;
    }

    /**
     * Execute the callback. The matches function needs to be called before this and return true
     * we don't take the first match since it's the path
     */
    public function exec() {
        return call_user_func_array($this->callback, array_slice($this->matches, 1));
    }
}
