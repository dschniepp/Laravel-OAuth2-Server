<?php

/**
 * Storage engines that support the "Extensible"
 * grant types should implement this interface
 * 
 * @author Dave Rochwerger <catch.dave@gmail.com>
 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.5
 */
interface IOAuth2GrantExtension extends IOAuth2Storage {

	/**
	 * Check any extended grant types.
	 * 
	 * @param string $uri
	 * URI of the grant type definition
	 * @param array $inputData
	 * Unfiltered input data. The source is *not* guaranteed to be POST (but
	 * is likely to be).
	 * @param array $authHeaders
	 * Authorization headers
	 * @return
	 * FALSE if the authorization is rejected or not support.
	 * TRUE or an associative array if you wantto verify the scope:
	 * @code
	 * return array(
	 * 'scope' => <stored scope values (space-separated string)>,
	 * );
	 * @endcode
	 * 
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-1.4.5
	 * @see http://tools.ietf.org/html/draft-ietf-oauth-v2-20#section-4.2
	 */
	public function checkGrantExtension($uri, array $inputData, array $authHeaders);
}