<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;

class AccessToken extends Eloquent {

	public static $table = 'access_tokens';
	public static $timestamps = true;
}
