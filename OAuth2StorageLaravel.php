<?php

use OAuth2Server\Models;
use OAuth2Server\Libraries;
use \Laravel;

class OAuth2StorageLaravel implements OAuth2Server\Libraries\IOAuth2GrantCode, OAuth2Server\Libraries\IOAuth2RefreshTokens {

	/**
	 * Little helper function to add a new client to the database.
	 *
	 * @param $client_id     Client identifier to be stored.
	 * @param $client_secret Client secret to be stored.
	 * @param $redirect_uri  Redirect URI to be stored.
	 */
	public function addClient($client_id, $client_secret, $redirect_uri) {
		try {
			$client_secret = \Laravel\Hash::make($client_secret . $client_id);

			$client = new \OAuth2Server\Models\Client();
			$client->client_id 		= $client_id;
			$client->client_secret 	= $client_secret;
			$client->redirect_uri 	= $redirect_uri;
			$client->save();

		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * Implements IOAuth2Storage::checkClientCredentials().
	 *
	 */
	public function checkClientCredentials($client_id, $client_secret = NULL) {
		try {
			$client = \OAuth2Server\Models\Client::where_client_id($client_id)->first();

			if ($client_secret === NULL) {
				return $client !== FALSE;
			}

			return \Laravel\Hash::check($client_secret . $client_id, $client->client_secret);
		} catch (PDOException $e) {
			$this->handleException($e);
		}
	}

	/**
	 * Implements IOAuth2Storage::getClientDetails().
	 */
	public function getClientDetails($client_id) {

		$client = \OAuth2Server\Models\Client::where_client_id($client_id)->first();

		if (is_null($client))
		{
			return FALSE;
		}
		else
		{
			unset($client->attributes['client_secret']);
			return $client->attributes;
		}
	}

	/**
	 * Implements IOAuth2Storage::getAccessToken().
	 */
	public function getAccessToken($oauth_token) {
		return $this->getToken($oauth_token, FALSE);
	}

	/**
	 * Implements IOAuth2Storage::setAccessToken().
	 */
	public function setAccessToken($oauth_token, $client_id, $user_id, $expires, $scope = NULL) {
		$this->setToken($oauth_token, $client_id, $user_id, $expires, $scope, FALSE);
	}

	/**
	 * @see IOAuth2Storage::getRefreshToken()
	 */
	public function getRefreshToken($refresh_token) {
		return $this->getToken($refresh_token, TRUE);
	}

	/**
	 * @see IOAuth2Storage::setRefreshToken()
	 */
	public function setRefreshToken($refresh_token, $client_id, $user_id, $expires, $scope = NULL) {
		return $this->setToken($refresh_token, $client_id, $user_id, $expires, $scope, TRUE);
	}

	/**
	 * @see IOAuth2Storage::unsetRefreshToken()
	 */
	public function unsetRefreshToken($refresh_token) {
		\OAuth2Server\Models\RefreshToken::where_refresh_token($refresh_token)->delete();
	}

	/**
	 * Implements IOAuth2Storage::getAuthCode().
	 */
	public function getAuthCode($oauth_code) {
		$code = \OAuth2Server\Models\AuthCode::where_code($oauth_code)->first();

		if(is_null($code))
			return NULL;
		else
			return $code->attributes;
	}

	/**
	 * Implements IOAuth2Storage::setAuthCode().
	 */
	public function setAuthCode($oauth_code, $client_id, $user_id, $redirect_uri, $expires, $scope = NULL) {
		try {

			$code =  new \OAuth2Server\Models\AuthCode();

			$code->code 		= $oauth_code;
			$code->client_id 	= $client_id;
			$code->user_id 		= $user_id;
			$code->redirect_uri = $redirect_uri;
			$code->expires 		= $expires;
			$code->scope 		= $scope;

			$code->save();

		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * @see IOAuth2Storage::checkRestrictedGrantType()
	 */
	public function checkRestrictedGrantType($client_id, $grant_type) {
		return TRUE; // Not implemented
	}

	/**
	 * Creates a refresh or access token
	 *
	 * @param string $token - Access or refresh token id
	 * @param string $client_id
	 * @param mixed $user_id
	 * @param int $expires
	 * @param string $scope
	 * @param bool $isRefresh
	 */
	protected function setToken($oauth_token, $client_id, $user_id, $expires, $scope, $isRefresh = TRUE) {
		try {

			if($isRefresh)
			{
				$token = new \OAuth2Server\Models\RefreshToken();
				$token->refresh_token = $oauth_token;
			}
			else
			{
				$token = new \OAuth2Server\Models\AccessToken();
				$token->oauth_token = $oauth_token;
			}

			$token->client_id 	= $client_id;
			$token->user_id 	= $user_id;
			$token->expires 	= $expires;
			$token->scope 		= $scope;

			$token->save();
		} catch (Exception $e) {
			$this->handleException($e);
		}
	}

	/**
	 * Retrieves an access or refresh token.
	 *
	 * @param string $token
	 * @param bool $refresh
	 */
	protected function getToken($oauth_token, $isRefresh = true) {
		if($isRefresh)
		{
			$token = \OAuth2Server\Models\RefreshToken::where_refresh_token($oauth_token)->first();
		}
		else
		{
			$token = \OAuth2Server\Models\AccessToken::where_oauth_token($oauth_token)->first();
		}

		if(is_null($token))
		{
			return NULL;
		}
		else
		{
			return $token->attributes;
		}
	}

   /**
    * By default, we do nothing and pass the ball.
    * Extend this class if you want to implement nice error handling here.
    *
    * @param  Exception $e
    * @return void
    * @throws Exception
    */
   protected function handleException($e) {
      throw $e;
   }

}
