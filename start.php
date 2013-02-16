<?php
/**
 * @author Daniel Schniepp < http://daniel-schniepp.com/ >
 * @copyright 2012 daniel-schniepp.com
 * @package OAuth2 Server (Laravel Bundle)
 * @version 1.0 - 2012-10-06
 */

Autoloader::map(array(
		'OAuth2StorageLaravel' => __DIR__ . '/OAuth2StorageLaravel.php',
));

Autoloader::namespaces(array(
    	'OAuth2Server\Models' => __DIR__.'/models',
    	'OAuth2Server\Libraries' => __DIR__.'/libraries',
));
