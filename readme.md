# Laravel OAuth2 Server

## Installation

### Artisan 1

	php artisan bundle:install oauth2-server

### Bundle Registration

Add the following to your **application/bundles.php** file:

	'oauth2-server' => array('auto' => true),

### Artisan 2

If you need to customize the default database structure, rename the **config/bundle.sample** file
to **config/bundle.php** and adapt it. Follow instructions inside the configuration file on how
to adapt migrations.

If you don't have any special needs, just run the migration task out of the box.

	php artisan migrate oauth2-server

### Add a client

	$client_id = '123'; 					// min-length is 3 chars!
	$client_secret = 'test';
	$redirect_uri = 'http://laravel.com';

	$oauth_strg = new OAuth2StorageLaravel();
	$oauth_strg->addClient($client_id, $client_secret, $redirect_uri);

>You can create a route in routes.php to add client

## Example

### Adding an OAuth2-Filter
application/routes.php

	Route::filter('oauth2', function()
	{
		try {
			$oauth = new OAuth2Server\Libraries\OAuth2(new OAuth2StorageLaravel());
			$token = $oauth->getBearerToken();
			$oauth->verifyAccessToken($token);
		} catch (OAuth2Server\Libraries\OAuth2ServerException $oauthError) {
			$oauthError->sendHttpResponse();
		}
	});

With that filter you can protect your routes via oauth

### OAuth2 Controller

application/controllers/oauth_controller.php

	<?php
	class OAuth_Controller extends Base_Controller
	{

	    public $restful = true;

		public function __construct()
		{
		    //$this->filter('before', 'oauth'); With Userbase
		    parent::__construct();
		}

	    public function get_authorize()
	    {
	    	$header = array('X-Frame-Options' => 'DENY');

		    $oauth = new OAuth2Server\Libraries\OAuth2(new OAuth2StorageLaravel());

			$input = Input::all();

			$input['response_type'] = 'code'; // Here you can set default type or optional params

			try {
				$data['oauth_params'] = $oauth->getAuthorizeParams($input);
			} catch (OAuth2Server\Libraries\OAuth2ServerException $oauthError) {
				$oauthError->sendHttpResponse();
			}

			return View::make('oauth.authorize', $data, $header);
		}

	    public function post_authorize()
	    {
	    	$header = array('X-Frame-Options' => 'DENY');
		    $oauth = new OAuth2Server\Libraries\OAuth2(new OAuth2StorageLaravel());

			$input = Input::all();
			$input['response_type'] = 'code'; // Here you can set default type or optional params

			try {
				$auth_params = $oauth->getAuthorizeParams($input);
			} catch (OAuth2Server\Libraries\OAuth2ServerException $oauthError) {
				$oauthError->sendHttpResponse();
			}


			$oauth->finishClientAuthorization(true, 123 , $auth_params);
			//$oauth->finishClientAuthorization(true, Auth::User()->id , $auth_params);	With Userbase
		}

	    public function post_access_token()
	    {
		    $oauth = new OAuth2Server\Libraries\OAuth2(new OAuth2StorageLaravel());
			try {
				$oauth->grantAccessToken();
			} catch (OAuth2Server\Libraries\OAuth2ServerException $oauthError) {
				$oauthError->sendHttpResponse();
			}
	    }
	}

### Authorize View

application/views/oauth.authorize.php

	<!doctype html>
	<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<title>Authorize</title>
		<meta name="viewport" content="width=device-width">
		{{ HTML::style('laravel/css/style.css') }}
	</head>
	<body>
		<div class="wrapper">
			<div role="main" class="main">
				<div class="home">
					{{ Form::open('oauth/authorize', 'POST') }}
					{{ Form::hidden('client_id', $oauth_params['client_id']) }}
					{{ Form::hidden('redirect_uri', $oauth_params['redirect_uri']) }}
					{{ Form::hidden('response_type', $oauth_params['response_type']) }}
					{{ Form::hidden('state', $oauth_params['state']) }}
					{{ Form::hidden('scope', $oauth_params['scope']) }}
					{{ Form::submit() }}
					{{ HTML::link('/' , 'Cancel') }}
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</body>
	</html>


### Extending classes

If you extend bundle classes (for example to customize the storage class), add them to the **classes**
configuration array so they can be registered automatically by the bundle.


### Final Tests

You can test your API with [OAuth 2.0 Playground](https://developers.google.com/oauthplayground/?hl=de)

Fork of https://github.com/quizlet/oauth2-php

Questions @danielschniepp
