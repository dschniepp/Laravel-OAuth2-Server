<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;

define("OAUTH2_SERVER_AUTH_CODES_TABLE", Config::get('oauth2-server::bundle.tables.auth_codes', 'auth_codes'));

class AuthCode extends Eloquent {

	public static $table = OAUTH2_SERVER_AUTH_CODES_TABLE;
	public static $timestamps = true;
}
