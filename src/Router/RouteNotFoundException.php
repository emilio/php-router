<?php
namespace Router;

/**
 * An exception derivation which represents that a route hasn't been found
 *
 * @package Router
 */
class RouteNotFoundException extends \Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}
