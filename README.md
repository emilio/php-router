# PHP Router

Lots of them out there, but this is super-simple, and mine ;)

## Usage

See index.php for a basic example and *remember to use the htaccess provided here*!

### Get the current url
```html
<a href="<?php echo $router->url('/users/username'); ?>">Username's profile</a>
```

### Blog example
```php
$router = new Router\Router('/blog');

$router->add('/', function() {
	// Show homepage
});

$router->add('/about', function() {
	// Show about page
});

$router->add('/([0-9]{4})', function($year) {
	// Show year archives
});

$router->add('/([0-9]{4})/([0-9]{2})', function ($year, $month) {
	// Show month archives
});

$router->add('/(.*)', function($slug) {
	// For example:
	if( Article::where('slug', '=', $slug)->first() ) {
		// Show article
	} else {
		// 404
	}
});

$router->post('/posts/create', function() {
	// Create a post
});

$router->post('/posts/update/([0-9]+)', function($post_id){
	// Update post with id = $post_id
});
```