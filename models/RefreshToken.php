<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;
use \Laravel\Config;

define("OAUTH2_SERVER_REFRESH_TOKENS_TABLE", Config::get('oauth2-server::bundle.tables.refresh_tokens', 'refresh_tokens'));

class RefreshToken extends Eloquent {

	public static $table = OAUTH2_SERVER_REFRESH_TOKENS_TABLE;
	public static $timestamps = true;
}
