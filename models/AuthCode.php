<?php

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;

class AuthCode extends Eloquent {

	public static $table = 'auth_codes';
	public static $timestamps = true;
}
