# PHP Router
Lots of them out there, but this is super-simple, and mine ;)

## Contributors
* [Emilio Cobos](https://github.com/ecoal95)
* [Bryan Velastegui](https://github.com/shinigamicorei7)

## Composer setup example
```json
{
    "require": {
        "ecoal95/php-router": "dev-master"
    }
}
```

## Usage
See the `examples/` to see a basic example and *remember to use the htaccess provided there*!

### Get urls
```html
<a href="<?php echo $router->url('/users/username'); ?>">Username's profile</a>
```

#### Get the current url
```php
$router->url();
```

### Blog example
```php
$router = new Router\Router('/blog');

$router->add('/', function() {
	echo 'homepage';
});

$router->add('/about', function() {
	echo 'about page';
});

$router->add('/([0-9]{4})', function($year) {
	echo $year . ' years active';
});

$router->add('/([0-9]{4})/([0-9]{2})', function ($year, $month) {
	echo 'archives from ' . $year . '/' . $month;
});

$router->add('/(.*)', function($slug) {
	// For example:
	if( Article::where('slug', '=', $slug)->first() ) {
		echo 'article';
	} else {
		echo '404';
	}
});

$router->post('/posts/create', function() {
	echo 'post created';
});

$router->post('/posts/update/([0-9]+)', function($post_id){
	// Update post with id = $post_id
});

// compare url with all registered routes
$router->route();
```
