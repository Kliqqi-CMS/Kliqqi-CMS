<?php
/*
 * Copyright (c) 2009 by Jeff Weisberg
 * Author: Jeff Weisberg
 * Created: 2009-Jun-22 16:44 (EDT)
 * Function: SolveMedia API php code
 *
 * $Id: solvemedialib.php,v 1.2 2010/09/16 18:43:14 ilia Exp $
 *
 * This is a PHP library that handles calling SolveMedia.
 *    - Documentation and latest version
 *          http://www.solvemedia.com/
 *    - Get a SolveMedia API Keys
 *          http://api.solvemedia.com/public/signup
 */

/* This code is based on code from,
 * and copied, modified and distributed with permission in accordance with its terms:
 *
 *   Copyright (c) 2007 reCAPTCHA
 *   AUTHORS:
 *     Mike Crawford
 *     Ben Maurer
 *
 *   Permission is hereby granted, free of charge, to any person obtaining a copy
 *   of this software and associated documentation files (the "Software"), to deal
 *   in the Software without restriction, including without limitation the rights
 *   to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 *   copies of the Software, and to permit persons to whom the Software is
 *   furnished to do so, subject to the following conditions:
 *
 *   The above copyright notice and this permission notice shall be included in
 *   all copies or substantial portions of the Software.
 *
 *   THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 *   IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 *   FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 *   AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 *   LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 *   OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 *   THE SOFTWARE.
 */

/**
 * The solvemedia server URL's
 */
define("ADCOPY_API_SERVER",        "http://api.solvemedia.com");
define("ADCOPY_API_SECURE_SERVER", "https://api-secure.solvemedia.com");
define("ADCOPY_VERIFY_SERVER",     "verify.solvemedia.com");
define("ADCOPY_SIGNUP",            "http://api.solvemedia.com/public/signup");

/**
 * Encodes the given data into a query string format
 * @param $data - array of string elements to be encoded
 * @return string - encoded request
 */
function _adcopy_qsencode ($data) {
        $req = "";
        foreach ( $data as $key => $value )
                $req .= $key . '=' . urlencode( stripslashes($value) ) . '&';

        // Cut the last '&'
        $req=substr($req,0,strlen($req)-1);
        return $req;
}



/**
 * Submits an HTTP POST to a solvemedia server
 * @param string $host
 * @param string $path
 * @param array $data
 * @param int port
 * @return array response
 */
function _adcopy_http_post($host, $path, $data, $port = 80) {

        $req = _adcopy_qsencode ($data);

        $http_request  = "POST $path HTTP/1.0\r\n";
        $http_request .= "Host: $host\r\n";
        $http_request .= "Content-Type: application/x-www-form-urlencoded;\r\n";
        $http_request .= "Content-Length: " . strlen($req) . "\r\n";
        $http_request .= "User-Agent: solvemedia/PHP\r\n";
        $http_request .= "\r\n";
        $http_request .= $req;

        $response = '';
        if( false == ( $fs = @fsockopen($host, $port, $errno, $errstr, 10) ) ) {
                die ('Could not open socket');
        }

        fwrite($fs, $http_request);

        while ( !feof($fs) )
                $response .= fgets($fs, 1024); // One TCP-IP packet [sic]
        fclose($fs);
        $response = explode("\r\n\r\n", $response, 2);

        return $response;
}



/**
 * Gets the challenge HTML (javascript and non-javascript version).
 * This is called from the browser, and the resulting solvemedia HTML widget
 * is embedded within the HTML form it was called from.
 * @param string $pubkey A public key for solvemedia
 * @param string $error The error given by solvemedia (optional, default is null)
 * @param boolean $use_ssl Should the request be made over ssl? (optional, default is false)

 * @return string - The HTML to be embedded in the user's form.
 */
function solvemedia_get_html ($pubkey, $error = null, $use_ssl = false)
{
	
	if ($pubkey == 'KLoj-jfX2UP0GEYOmYX.NOWL0ReUhErZ' || $pubkey == '' || $pubkey == null ){
		
		$pubkey = 'KLoj-jfX2UP0GEYOmYX.NOWL0ReUhErZ'; // Redeclare default key in case of null value
	
		$page_file = basename($_SERVER['PHP_SELF']); // Get the file generating the page to figure out what key to assign it
		
		if ($page_file == "register.php"){ // Register CAPTCHA
			$pubkey = 'Ql92.ORmU5DjtPyAdAW4i6OghCHVPtsq';
		} elseif ($page_file == "story.php"){ // Comment CAPTCHA
			$pubkey = 'AufuaJDa73CtTXf2VZ7NY8MQewLMWcEX';
		} elseif ($page_file == "submit.php"){ // Story Submission CAPTCHA
			$pubkey = 'h5HLnVA0W5kRZWIlPf7mEixB5A6koX4p';
		}
	}
	
	if ($use_ssl) {
                $server = ADCOPY_API_SECURE_SERVER;
        } else {
                $server = ADCOPY_API_SERVER;
        }

        $errorpart = "";
        if ($error) {
           $errorpart = ";error=1";
        }
        return '<script type="text/javascript" src="'. $server . '/papi/challenge.script?k=' . $pubkey . $errorpart . '"></script>

	<noscript>
  		<iframe src="'. $server . '/papi/challenge.noscript?k=' . $pubkey . $errorpart . '" height="300" width="500" frameborder="0"></iframe><br/>
  		<textarea name="adcopy_challenge" rows="3" cols="40"></textarea>
  		<input type="hidden" name="adcopy_response" value="manual_challenge"/>
	</noscript>';
}




/**
 * A SolveMediaResponse is returned from solvemedia_check_answer()
 */
class SolveMediaResponse {
        var $is_valid;
        var $error;
}


/**
  * Calls an HTTP POST function to verify if the user's guess was correct
  * @param string $privkey
  * @param string $remoteip
  * @param string $challenge
  * @param string $response
  * @param string $hashkey
  * @return SolveMediaResponse
  */
function solvemedia_check_answer ($privkey, $remoteip, $challenge, $response, $hashkey = '' )
{

	if ($privkey == 'Dm.c-mjmNP7Fhz-hKOpNz8l.NAMGp0wO' || $privkey == '' || $privkey == null ){
		
		// Re-declare the default private key and hash in case of null value
		$privkey = 'Dm.c-mjmNP7Fhz-hKOpNz8l.NAMGp0wO';
		$hashkey = 'nePptHN4rt.-UVLPFScpSuddqdtFdu2N';
		
		$page_file = basename($_SERVER['PHP_SELF']); // Get the file generating the page to figure out what key to assign it
		if ($page_file == "register.php"){
			$privkey = 'RfinGw00jddSv9eqIEo.LDUcZSbSEU6S';
			$hashkey = 'SoR.tNYZtGpSkFrMBrLP2kPrpyiYyQpM';
		} elseif ($page_file == "story.php"){
			$privkey = 'MdwcHqbrYQPcJt0JjXSMrgFwROeLY5Ce';
			$hashkey = 'xRJmWazYhZm6zSrrgdZHHctXUTYK6fZa';
		} elseif ($page_file == "submit.php"){
			$privkey = 'gAilaBopkMs8Bk9R9wx6mhRdl1ljt9Ig';
			$hashkey = 'VH9T8Zr8EeUqUiGWfjZpbkS9u.sGf1cp';
		}
	}

	if ($remoteip == null || $remoteip == '') {
		die ("For security reasons, you must pass the remote ip to solvemedia");
	}

        //discard spam submissions
        if ($challenge == null || strlen($challenge) == 0 || $response == null || strlen($response) == 0) {
                $adcopy_response = new SolveMediaResponse();
                $adcopy_response->is_valid = false;
                $adcopy_response->error = 'incorrect-solution';
                return $adcopy_response;
        }

        $response = _adcopy_http_post (ADCOPY_VERIFY_SERVER, "/papi/verify",
                                          array (
                                                 'privatekey' => $privkey,
                                                 'remoteip'   => $remoteip,
                                                 'challenge'  => $challenge,
                                                 'response'   => $response
                                                 )
                                          );

        $answers = explode ("\n", $response [1]);
        $adcopy_response = new SolveMediaResponse();

        if( strlen($hashkey) ){
			# validate message authenticator
			$hash = sha1( $answers[0] . $challenge . $hashkey );

			if( $hash != $answers[2] ){
					$adcopy_response->is_valid = false;
					$adcopy_response->error = 'hash-fail';
					return $adcopy_response;
			}
        }

        if (trim ($answers [0]) == 'true') {
            $adcopy_response->is_valid = true;
        }
        else {
			$adcopy_response->is_valid = false;
			$adcopy_response->error = $answers [1];
        }
        return $adcopy_response;

}

/**
 * gets a URL where the user can sign up for solvemedia. If your application
 * has a configuration page where you enter a key, you should provide a link
 * using this function.
 * @param string $domain The domain where the page is hosted
 * @param string $appname The name of your application
 */
function solvemedia_get_signup_url ($domain = null, $appname = null) {
	return ADCOPY_SIGNUP . "?" .  _adcopy_qsencode (array ('domain' => $domain, 'app' => $appname));
}


/* Mailhide related code */
/* [ deleted ] */

?>
