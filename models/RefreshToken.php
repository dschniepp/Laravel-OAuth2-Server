<?php 

namespace OAuth2Server\Models;
use \Laravel\Database\Eloquent\Model as Eloquent;

class RefreshToken extends Eloquent {
	
	public static $table = 'refresh_tokens';
	public static $timestamps = true;
}