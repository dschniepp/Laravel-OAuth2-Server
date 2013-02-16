<?php

namespace OAuth2Server\Libraries;

/**
 * Redirect the end-user's user agent with error message.
 *
 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1
 *
 * @ingroup oauth2_error
 */
class OAuth2RedirectException extends \OAuth2Server\Libraries\OAuth2ServerException {

	protected $redirectUri;

	/**
	 * @param $redirect_uri
	 * An absolute URI to which the authorization server will redirect the
	 * user-agent to when the end-user authorization step is completed.
	 * @param $error
	 * A single error code as described in Section 4.1.2.1
	 * @param $error_description
	 * (optional) A human-readable text providing additional information,
	 * used to assist in the understanding and resolution of the error
	 * occurred.
	 * @param $state
	 * (optional) REQUIRED if the "state" parameter was present in the client
	 * authorization request. Set to the exact value received from the client.
	 *
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.1.2.1
	 *
	 * @ingroup oauth2_error
	 */
	public function __construct($redirect_uri, $error, $error_description = NULL, $state = NULL) {
		parent::__construct(OAuth2::HTTP_FOUND, $error, $error_description);

		$this->redirectUri = $redirect_uri;
		if ($state) {
			$this->errorData['state'] = $state;
		}

	}

	/**
	 * Redirect the user agent.
	 *
	 * @ingroup oauth2_section_4
	 */
	protected function sendHeaders() {
		$params = array('query' => $this->errorData);
		header("Location: " . $this->buildUri($this->redirectUri, $params));
		exit(); // No point in printing out data if we're redirecting
	}

	/**
	 * Build the absolute URI based on supplied URI and parameters.
	 *
	 * @param $uri
	 * An absolute URI.
	 * @param $params
	 * Parameters to be append as GET.
	 *
	 * @return
	 * An absolute URI with supplied parameters.
	 *
	 * @ingroup oauth2_section_4
	 */
	protected function buildUri($uri, $params) {
		$parse_url = parse_url($uri);

		// Add our params to the parsed uri
		foreach ( $params as $k => $v ) {
			if (isset($parse_url[$k]))
				$parse_url[$k] .= "&" . http_build_query($v);
			else
				$parse_url[$k] = http_build_query($v);
		}

		// Put humpty dumpty back together
		return ((isset($parse_url["scheme"])) ? $parse_url["scheme"] . "://" : "") . ((isset($parse_url["user"])) ? $parse_url["user"] . ((isset($parse_url["pass"])) ? ":" . $parse_url["pass"] : "") . "@" : "") . ((isset($parse_url["host"])) ? $parse_url["host"] : "") . ((isset($parse_url["port"])) ? ":" . $parse_url["port"] : "") . ((isset($parse_url["path"])) ? $parse_url["path"] : "") . ((isset($parse_url["query"])) ? "?" . $parse_url["query"] : "") . ((isset($parse_url["fragment"])) ? "#" . $parse_url["fragment"] : "");
	}
}
