<?php
include 'src/Router/Route.php';
include 'src/Router/Router.php';

$router = new Router\Router('/demos/php-router');

$router->add('/', function() {
	global $router;
	?>
		<h1>PHP Router</h1>
		<a href="<?php echo $router->url('/hola-mundo'); ?>">Hola, Mundo!</a>
		<?php if(isset($_GET['example'])): ?>
			<pre><code>$_GET['example'] = <?php echo htmlspecialchars($_GET['example']); ?></code></pre>
		<?php endif; ?>
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

$router->add('/user(?:/([0-9]+)?)', function($user_id = null) {
	if( $user_id === null ) {
		echo "No hay id de usuario";
	} else {
		echo "UID = $user_id";
	}
});

$router->add('/.*', function() {
	header($_SERVER["SERVER_PROTOCOL"]." 404 Not Found");
	echo '<h1>404 - No hay ruta para esto</h1>';
});
$router->route();
