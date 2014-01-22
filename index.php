<?php use Router\Router;
include 'src/Route.php';
include 'src/Router.php';

$router = new Router('/php-router');

$router->add('/', function() { 
	global $router;
	?>
		<h1>PHP Router</h1>
		<a href="<?php echo $router->url('/hola-mundo'); ?>">Hola, Mundo!</a>
	<?php
});

$router->add('/hola-mundo', function() {
	echo '<h1>Hola, mundo!</h1>';
});

$router->add('/hola-([a-zA-Z-]+)', function($nombre) {
	$nombre = str_replace('-', ' ', $nombre);
	echo "<h1>Hola, $nombre</h1>";
});

$router->add('/hola/([a-zA-Z-\s]+)', function($nombre) {
	echo "<h1>Hola, $nombre</h1>";
});

$router->add('/.*', function() {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	echo '<h1>404 - No hay ruta para esto</h1>';
});
$router->route();