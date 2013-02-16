<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;

define("OAUTH2_SERVER_CLIENTS_TABLE", Config::get('oauth2-server::bundle.tables.clients', 'clients'));

class Client extends Eloquent {

	public static $table = OAUTH2_SERVER_CLIENTS_TABLE;
	public static $timestamps = true;
}
