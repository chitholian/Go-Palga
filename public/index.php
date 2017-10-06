<?php
//die(phpinfo());
//foreach(get_loaded_extensions() as $ext) print $ext ."<br/>";die();
//die (print_r(get_loaded_extensions()));
/**
 * Laravel - A PHP Framework For Web Artisans
 *
 * @package  Laravel
 * @author   Taylor Otwell <taylor@laravel.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| our application. We just need to utilize it! We'll simply require it
| into the script here so that we don't have to worry about manual
| loading any of our classes later on. It feels great to relax.
|
*/

require __DIR__.'/../bootstrap/autoload.php';

/***************** Mime Type Guesser *************/
class CustomTypeGuesser implements Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesserInterface {

	/**
	 * Guesses the mime type of the file with the given path.
	 *
	 * @param string $path The path to the file
	 *
	 * @return string The mime type or NULL, if none could be guessed
	 *
	 * @throws \Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException If the file does not exist
	 * @throws \Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException If the file could not be read
	 */

	public function guess($path){
		return 'application/octet-stream';
	}
}

$guesser = Symfony\Component\HttpFoundation\File\MimeType\MimeTypeGuesser::getInstance();
$guesser->register(new CustomTypeGuesser());


/*
|--------------------------------------------------------------------------
| Turn On The Lights
|--------------------------------------------------------------------------
|
| We need to illuminate PHP development, so let us turn on the lights.
| This bootstraps the framework and gets it ready for use, then it
| will load up this application so that we can run it and send
| the responses back to the browser and delight our users.
|
*/

$app = require_once __DIR__.'/../bootstrap/app.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request
| through the kernel, and send the associated response back to
| the client's browser allowing them to enjoy the creative
| and wonderful application we have prepared for them.
|
*/

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);
