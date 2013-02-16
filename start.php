<?php
/**
 * @author Daniel Schniepp < http://daniel-schniepp.com/ >
 * @copyright 2012 daniel-schniepp.com
 * @package OAuth2 Server (Laravel Bundle)
 * @version 1.0 - 2012-10-06
 */

$mappings = array('OAuth2StorageLaravel' => __DIR__.'/OAuth2StorageLaravel.php');
foreach(Config::get('oauth2-server::bundle.classes') as $mapping => $file)
{
   $mappings[$mapping] = __DIR__.'/'.ltrim($file, '/');
}
Autoloader::map($mappings);

Autoloader::namespaces(array(
    	'OAuth2Server\Models' => __DIR__.'/models',
    	'OAuth2Server\Libraries' => __DIR__.'/libraries',
));
