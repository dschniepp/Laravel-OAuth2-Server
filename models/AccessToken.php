<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;

define("OAUTH2_SERVER_ACCESS_TOKEN_TABLE", Config::get('oauth2-server::bundle.tables.access_tokens', 'access_tokens'));

class AccessToken extends Eloquent {

	public static $table = OAUTH2_SERVER_ACCESS_TOKEN_TABLE;
	public static $timestamps = true;
}
