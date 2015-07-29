<?php
include 'src/Router/Route.php';
include 'src/Router/Router.php';

$router = new Router\Router('/public');

$router->route();
