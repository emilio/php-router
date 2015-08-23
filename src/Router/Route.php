<?php
namespace Router;

/**
 * A class representing a registered route. Each route is composed of a regular expression,
 * an array of allowed methods, and a callback function to execute if it matches.
 *
 * @package Router
 */
class Route
{
    /** @var string The regular expresion */
    private $expr;
    /** @var callable The callback function */
    private $callback;
    /** @var array The matches of $expr, which will be the arguments of the callback */
    private $matches;
    /** @var Allowed methods for this route */
    private $methods = array('GET', 'POST', 'HEAD', 'PUT', 'DELETE');

    /**
     * Constructor
     *
     * @param string $expr regular expresion to test against
     * @param function $callback function executed if route matches
     * @param string|array $methods methods allowed
     */
    public function __construct($expr, $callback, $methods = null)
    {
        // Allow an optional trailing backslash
        $this->expr = '#^' . $expr . '/?$#';
        $this->callback = $callback;

        if ($methods !== null) {
            $this->methods = is_array($methods) ? $methods : array($methods);
        }
    }

    /**
     * See if route matches with path
     *
     * @param string $path
     * @return boolean
     */
    public function matches($path)
    {
        if (preg_match($this->expr, $path, $this->matches) &&
            in_array($_SERVER['REQUEST_METHOD'], $this->methods)) {
            return true;
        }

        return false;
    }

    /**
     * Execute the callback.
     * The matches function needs to be called before this and return true.
     * We don't take the first match since it's the whole path
     */
    public function exec()
    {
        return call_user_func_array($this->callback, array_slice($this->matches, 1));
    }
}
