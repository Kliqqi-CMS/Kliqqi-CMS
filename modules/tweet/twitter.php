<?php

if (!class_exists('TwitterOauth'))
{
require_once("OAuth.php");

class TwitterException extends Exception {
  const TOKEN_REQUIRED = 1;
  const REMOTE_ERROR   = 2;
  const REQUEST_FAILED = 3;
  const CONNECT_FAILED = 4;

  public $response;
  
  public static $TW_DUMP_REQUESTS = '';

  function __construct($msg, $code, $response=null) {
    parent::__construct($msg, $code);
    $this->response = $response;
    
    if (self::$TW_DUMP_REQUESTS) {
	    $datetime = new DateTime();
	    $datetime =  $datetime->format(DATE_ATOM);
    
	    file_put_contents(self::$TW_DUMP_REQUESTS, 
	    "\r\n====================================================\r\n".
	    "time: $datetime\r\n" .
	    "message:\r\n--------------------------\r\n$msg\r\n\r\n" .
	    "code:\r\n----------------------------\r\n$code\r\n\r\n" .
	    "response:\r\n----------------------------\r\n$response\r\n\r\n",
			FILE_APPEND);
    }
    
  }
}

class TwitterOauth {


/**
* @access public
*/
  public static $TW_API_ROOT = "http://api.twitter.com/oauth";

/**
* @access public
*/
  public static $TW_DUMP_REQUESTS = '';
  // set to a pathname to dump out http requests to a log. For example, "./ms.log"

  // OAuth URLs
  public function requestTokenURL() { return self::$TW_API_ROOT.'/request_token'; }
  public function authorizeURL() { return self::$TW_API_ROOT.'/authorize'; }
  public function accessTokenURL() { return self::$TW_API_ROOT.'/access_token'; }


  //new external functions

  /**
   * Sets up the TwitterID API with your credentials
   *
   * @param String $consumerKey
   * @param String $consumerSecret
   * @param String $oAuthToken
   * @param String $oAuthTokenSecret
   * @return object a new Twitter object
   */
  public function __construct($consumerKey,
		       $consumerSecret,
		       $oAuthToken = null,
		       $oAuthTokenSecret = null,
		       $authorized_verifier = '')  {
  
    $this->sha1_method = new OAuthSignatureMethod_HMAC_SHA1();
    $this->consumer = new OAuthConsumer($consumerKey, $consumerSecret, NULL);
    $this->authorized_verifier = $authorized_verifier;
	
    if (!empty($oAuthToken)) {
    	$this->token = new OAuthConsumer($oAuthToken, $oAuthTokenSecret);
    } else {
      $this->token = NULL;
    }
  }

    /**
   * Get a request token for authenticating your application with FE.
   *
   * @return a key/value pair array containing: oauth_token and
   * oauth_token_secret.
   */
  public function getRequestToken() {
	  /**
	  *@link http://oauth.net/core/1.0/#http_codes
	  * HTTP 400 Bad Request
	  	Unsupported parameter
		Unsupported signature method
		Missing required parameter
		Duplicated OAuth Protocol Parameter
	   * HTTP 401 Unauthorized
	   	Invalid Consumer Key
		Invalid / expired Token
		Invalid signature
		Invalid / used nonce
	  */
	  
	  /*consumer key is not set!! or is wrong
	  Fatal error: Uncaught exception 'TwitterException' with message 'Request to http://api.Twitter.com/request_token?oauth_version=1.0&oauth_nonce=9a5139f46cb96314a7d5a3faf6ee95ca&oauth_timestamp=1238041272&oauth_consumer_key=NOT%20SET&oauth_signature_method=HMAC-SHA1&oauth_signature=8RqzekFfhFmAsXAql3RHJTX9A%2Fc%3D failed:<br/><br/> HTTP error 401 <br/><br/> Response:<br/><br/> HTTP/1.1 401 oauth_problem=consumer_key_unknown Date: Thu, 26 Mar 2009 04:21:12 GMT Server: Microsoft-IIS/6.0 WWW-Authenticate: OAuth realm="http://api.Twitter.com/authorization", oauth_problem=consumer_key_unknown Set-Cookie: MSCulture=IP=208.113.234.71&IPCulture=en-US&PreferredCulture=en-US&PreferredCulturePending=&Country=VVM=&ForcedExpiration=633736128723757790&timeZone=0&myStuffDma=&USRLOC=QXJlYUNvZGU9NzE0JkNpdHk9QnJlYSZDb3VudHJ5Q29kZT1VUyZDb3VudHJ5TmFtZT1Vbml0ZWQgU3RhdGVzJkRtYUNvZGU9ODAzJkxhdGl0dWRlPTMzLjkyNjkmTG9uZ2l0dWRlPS0xMTcuODYxMiZQb3N0YWxDb2RlPTkyODIxJlJlZ2lvbk5hbWU9Q0E=; domain=.Twitter.com; expires=Sat, 25-Apr-2009 04:21:12 GMT in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php on line 1197
	  */
	  
    $r = $this->oAuthRequest($this->requestTokenURL());

    $token = $this->oAuthParseResponse($r);

    $this->token = new OAuthConsumer($token['oauth_token'], $token['oauth_token_secret']); // use this token from now on

    if (self::$TW_DUMP_REQUESTS){
    	self::dump(
    				"Now the user is redirected to ".$this->getAuthorizeURL($token['oauth_token']).
    				"\nOnce the user returns, via the callback URL for web authentication".
    				" or manually for desktop authentication, we can get their access token".
    				" and secret by calling /oauth/access_token.".
    				"\n\n");
    }
    return $token;
  }

  /**
   * Get the URL to redirect to to authorize the user and validate a
   * request token.
   *
   * @returns a string containing the URL to redirect to.
   */
  public function getAuthorizeURL($token) {
    // $token can be a string, or an array in the format returned by getRequestToken().
    if (is_array($token)) $token = $token['oauth_token'];

	return 	(
	    		$this->authorizeURL() .
	    		'?oauth_token=' .
	    			$token .
	    		'&oauth_callback=http://' .
		    		$_SERVER['HTTP_HOST'] .
		    		$_SERVER['SCRIPT_NAME'] .
	    		'?f=callback'
    		);
  }

   /**
   * Exchange the request token and secret for an access token and
   * secret, to sign API calls.
   *
   * @param RequestToken $token
   * @return array("oauth_token" => the access token,
   *                "oauth_token_secret" => the access secret)
   */
  public function getAccessToken($token=NULL) {
    $this->requireToken();

    $r = $this->oAuthRequest($this->accessTokenURL(), array(
    	"oauth_verifier"=> $this->authorized_verifier));

    $token = $this->oAuthParseResponse($r);

    $this->token = new OAuthConsumer(
    					$token['oauth_token'],
    					$token['oauth_token_secret']);
    					// use this token from now on

    return $this->token;
  }

  /**
   *
   * @param $json a java script object
   *
   * @return Object - a PHP object that represents the JSON
   * */
  public function parseJSON($json) {
  	if(gettype($json)=="object"){
  		return $json;
  	}

    $r = json_decode($json);

    if (empty($r)){
    	throw new TwitterException("Empty JSON response",
    								TwitterException::REQUEST_FAILED);
    }

    if (isset($r->rsp) && $r->rsp->stat != 'ok') {
	    throw new TwitterException(
    								$r->rsp->code.": ".$r->rsp->message,
    								TwitterException::REMOTE_ERROR,
    								$r->rsp
    							);
    }
    return $r;
  }
  
  /**
  * based on the content type different types are returned
  * @param 	string 	$contentType
  * @param 	mixed 	$data
  * @return mixed
  */
  private function parseResponse($data, $contentType){
	  switch(strtolower(trim($contentType)))
	  {
	  case 'application/x-www-form-urlencoded':
		  return OAuthUtil::decodeUrlEncodedArray($data);
		  break;
	  case 'application/json':
		  return self::parseJSON($data);
		  break;
	  case 'application/xml':
		  return new SimpleXML($data);
		  break;
	  case 'application/xml+atom':
		  return new SimpleXML($data);
		  break;
	  case 'text/html':
		  /*
		  Fatal error: Uncaught exception 'TwitterException' with message 'Requested --> http://api.Twitter.com/v1/users/36452044/status.json Response:<br/><br/> <br/><br/> :: contentType ::\r\ntext/html :: status ::\r\n405 :: body ::\r\n :: headers ::\r\n{"statusCode":"405","statusDescription":null} ' in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php:772 Stack trace: #0 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php(380): Twitter->makeOAuthRequest('http://api.mysp...', NULL, 'PUT', Array, Array) #1 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/samples/Twitterid-openid-oauth/finish_auth.php(58): Twitter->updateStatus(36452044) #2 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/samples/Twitterid-openid-oauth/finish_auth.php(68): run() #3 {main} thrown in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php on line 772
		  */
		  return (string)$data;
		  break;
	  default:
		  //we do not know what type it is
		  return (string)$data;
		  //break;
	  }
  }
  
  /**
  * creates a properly formated body
  *@param mixed $body			the body that you want formated for the given content type
  *@param string $contentType	the content type to PUT or POST in the body
  */
  private function formatBody($body, $contentType='application/x-www-form-urlencoded'){
	  if(!empty($body) && $contentType == 'application/x-www-form-urlencoded'){
		  if( is_array($body) ){
			  //create 'application/x-www-form-urlencoded' string
			  $bodyContent = OAuthUtil::encodeUrlEncodedArray($body);
			  return $bodyContent;
			  
		  }elseif( is_string($body) ){
			  //validate $body as 'application/x-www-form-urlencoded' string
			  return $body;
			  
		  }elseif( is_object($body) ){
			  //not all objects can be converted
			  
		  }else{
			  //content type and $body are not compatible
			  
		  }
	  }
	  
	  return NULL;
  }

  /** Parse a URL-encoded OAuth response
   * @param 	$responseString
   * @return 	Hash Map
   * */
  protected function oAuthParseResponse($responseString) {
    $r = array();
    foreach (explode('&', $responseString) as $param) {

      $pair = explode('=', $param, 2);

      if (count($pair) != 2) continue;

      $r[urldecode($pair[0])] = urldecode($pair[1]);

    }
    return $r;
  }
  
  /** Format and sign an OAuth / API request
  *	add support/ error handeling for all error types
  *	this does not support multipart bodies
  *   returns a response object
  *@param string $url 		the url of the API REST resource
  *@param string $qParams	the non-oauth (optional) query parameters
  *@param string $method	the HTTP Request method/ verb (GET, POST, PUT, DELETE, etc...)
  *@param string $headers	optional additional headers can be used to set the Content-Type of the body
  *@param string|array $body	a string or array with content that should be sent in the body of the request
  *
  *@return responseObject
  */
  public function makeOAuthRequest(
	  $url, 
	  $qParams=array(), 
	  $method,
	  $headers=array('Content-Type'=> 'application/x-www-form-urlencoded'),
	  $body=NULL){
  
	
  	  if (self::$TW_DUMP_REQUESTS) {
	  	  $datetime = new DateTime();
	    	  $datetime =  $datetime->format(DATE_ATOM);

		  $dump = "\r\n";
		  $dump .= '::makeOAuthRequest::@'.$datetime."\r\n";
		  $dump .= "_____________________________________________\r\n";
		  $dump .= '::reqUrl::\'' . $method . '\'  '.$url."\r\n";
		  $dump .= '::reqParams::' . OAuthUtil::encodeUrlEncodedArray( $qParams ). "\r\n";
		  $dump .= '::headers::'."\r\n";
		  foreach($headers as $key => $value){
			  $dump .= $key . ': ' . $value . "\r\n";
		  }
		  $dump .= "\r\n";
		  self::dump($dump);
	  }
  
	  //validate $url
	  //validate $qParams
	  //validate $method
	  if(!self::isSupportedMethod($method)){
		  //raise error, unsupported request method
	  }
	  
	  //validate $headers
	  //get BodyContentType
	  
	  if (self::$TW_DUMP_REQUESTS) {
		  $dump = '::BODY::'."\r\n";
		  if(is_array($body)){
			  $dump .= OAuthUtil::encodeUrlEncodedArray($body) . "\r\n\r\n";
		  }else{
			  $dump .= $body . "\r\n\r\n";
		  }
		  self::dump($dump);
	  }
	  
	  $bodyContentType = $headers['Content-Type'];
	  if(empty($bodyContentType)){
		 //raise error, Content-Type is not set, or may not have the propper casing
	  }
	  
	  if(!self::isSupportedRequestContentType($bodyContentType)){
		  //raise error
	  }
	  
	  /*
	  //formats the body based on its type and the content type
	  we are going to send the body as an array of params
	  $bodyContent = self::formatBody($body, $bodyContentType);
	  */
	  
	  if(!is_array($body)){
		  //right now we want to make sure the body can be signed properly and this requires we process the body as an array of prams
	  }
	  /*
	  if (self::$TW_DUMP_REQUESTS) {
		  $dump = '::BODY CONTENT::'."\r\n";
		  $dump .= $bodyContent . "\r\n\r\n";
		  self::dump($dump);
		  
		 
	  }
	  */
	  //construct the request object
	  $req = OAuthRequest::from_consumer_and_token(
	    				$this->consumer,
	    				$this->token,
	    				$method,
	    				$url,
	    				$qParams,
						$headers,
						$body);
	  
	  //passes a reference to the SHA1-Signing Class to sign the request
	  $req->sign_request($this->sha1_method, $this->consumer, $this->token);
	  
	  
	  
	  //any query params should be in the url aready
	  //any post data should be in the body already
	  $Twitter_response = $this->makeHttpRequest(
											$req->get_normalized_http_method(),
											$req->to_auth_url(),
											null,
											$req->get_custom_headers(),
											$req->to_nonAuth_postdata()
											);
	  /*
	  if(!self::isSupportedResponseContentType($Twitter_response['content_type')){
	  
	  }*/
	  
	  //dump response
	  if (self::$TW_DUMP_REQUESTS) {
		  $datetime = new DateTime();
		  $datetime =  $datetime->format(DATE_ATOM);

		  $dump = "\r\n\r\n".'::Twitter response::@' . $datetime . "\r\n";
		  $dump .= "_____________________________________________\r\n";
		  foreach($Twitter_response as $key => $value){
			  $dump .= 	':: ' . $key . ' :: '."\r\n" 
						. $value . "\r\n\r\n";
		  }
		  self::dump($dump);
	  }
	  
	  //i should probably validate the response and check for error messages
	  
	  switch((int)$Twitter_response['status'])
	  {
	  	  case 200:
			  //there is not a break line because we want 200's and 201's to act the same.
			  return $Twitter_response;
	  	  case 201:
			  //200 success
			  //201 success on put
			  return $Twitter_response;
			  
			  break;
		  case 401:
			  /*consumer key is not set!! or is wrong
	  Fatal error: Uncaught exception 'TwitterException' with message 'Request to http://api.Twitter.com/request_token?oauth_version=1.0&oauth_nonce=9a5139f46cb96314a7d5a3faf6ee95ca&oauth_timestamp=1238041272&oauth_consumer_key=NOT%20SET&oauth_signature_method=HMAC-SHA1&oauth_signature=8RqzekFfhFmAsXAql3RHJTX9A%2Fc%3D failed:<br/><br/> HTTP error 401 <br/><br/> Response:<br/><br/> HTTP/1.1 401 oauth_problem=consumer_key_unknown Date: Thu, 26 Mar 2009 04:21:12 GMT Server: Microsoft-IIS/6.0 WWW-Authenticate: OAuth realm="http://api.Twitter.com/authorization", oauth_problem=consumer_key_unknown Set-Cookie: MSCulture=IP=208.113.234.71&IPCulture=en-US&PreferredCulture=en-US&PreferredCulturePending=&Country=VVM=&ForcedExpiration=633736128723757790&timeZone=0&myStuffDma=&USRLOC=QXJlYUNvZGU9NzE0JkNpdHk9QnJlYSZDb3VudHJ5Q29kZT1VUyZDb3VudHJ5TmFtZT1Vbml0ZWQgU3RhdGVzJkRtYUNvZGU9ODAzJkxhdGl0dWRlPTMzLjkyNjkmTG9uZ2l0dWRlPS0xMTcuODYxMiZQb3N0YWxDb2RlPTkyODIxJlJlZ2lvbk5hbWU9Q0E=; domain=.Twitter.com; expires=Sat, 25-Apr-2009 04:21:12 GMT in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php on line 1197
	  */
	  
	  /*
	  Fatal error: Uncaught exception 'TwitterException' with message 'Requested --> http://api.Twitter.com/v1/users/36452044/status Response:<br/><br/> <br/><br/> :: contentType ::\r\napplication/xml :: status ::\r\n401 :: body ::\r\n :: headers ::\r\n<error xmlns="api-v1.Twitter.com"><statuscode>401</statuscode><statusdescription>Authentication failed. Failed to resolve application URI "01d4153357314a9da0c02f8e4c1270ae,01d4153357314a9da0c02f8e4c1270ae"</statusdescription></error> ' in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php:772 Stack trace: #0 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php(380): Twitter->makeOAuthRequest('http://api.mysp...', NULL, 'PUT', Array, Array) #1 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/samples/Twitterid-openid-oauth/finish_auth.php(58): Twitter->updateStatus(36452044) #2 /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/samples/Twitterid-openid-oau in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php on line 772
	  */
			  //suspended app
			  //insuffecient app permission
			  //insuffecient user or application permission
			  //incorrect user
			  //missing or revoked token
			  //insuffecient OpenCanvas Permissions
			  //user has not added app
			  //expired timestamp
			  break;
		  case 403:
			  //missing oauth params
			  //expired timestamp
			  //used nonce
			  //invalid key
			  //invalid token
			  break;
		  case 404:
			  //the resource is not found
			  //missing user
			  break;
		  case 411:
			  //missing content length
			  break;
		  case 500:
		  	  //internal server error
			  break;
	  }
	  
	  //if we are still here we did not handle the error
	  
	  throw new TwitterException(
		  			"Requested --> $url \r\n" . 
					"Response:<br/><br/>\r\n\r\n".
	      			"<br/><br/>\r\n".
					$dump, 
					TwitterException::REQUEST_FAILED);
  }
  
  
  /**
  *  this function will make a raw HTTP requests using PHP's cURL
  *
  *  //maybe? make* functions should always be called with a try(){}catch(){}
  */
  private function makeHttpRequest(
	  $method, 
	  $url, 
	  $qParams, 
	  $headers=array(), 
	  $bodyContent=NULL
	  ){
  	  
  
  
  	  if (self::$TW_DUMP_REQUESTS) {
  		  $datetime = new DateTime();
    		  $datetime =  $datetime->format(DATE_ATOM);

		  $dump = "\r\n";
		  $dump .= '::makeHttpRequest::@'.$datetime."\r\n";
		  $dump .= "_____________________________________________\r\n";
		  $dump .= '::reqUrl::\'' . $method . '\'  ' . $url . "\r\n";
		  $dump .= '::reqParams::' . OAuthUtil::encodeUrlEncodedArray( $qParams ) . "\r\n";
		  $dump .= '::custom headers::'."\r\n";
		  foreach($headers as $key => $value){
			  $dump .= $key . ': ' . $value . "\r\n";
		  }
		  $dump .= "\r\n";
		  $dump .= '::bodyContent::'."\r\n";
		  $dump .= $bodyContent;
		  self::dump($dump);
	  }
  
  //this url, may or may not have signed params on it already,
  //if it does, we may not want more params
  
  //hmmm what about the body content being signed?
  	  
  	  if(!self::isSupportedMethod($method)){
		  //raise error, unsupported request method
	  }
	  
	  //not sure if this is needed yet
	  $url_bits = parse_url($url);
	  $req_url = $url_bits['path'];
	  
	  if(empty($bodycontent)){
		  //if we are doing a GET, the query params need to be in the request url
		  //maybe for DELETE too?
		  //still not sure about this
		  if ($url_bits['query']) $req_url .= '?' . $url_bits['query'];
	  }
	  
	  //init curl
	  $ch = curl_init();
	  
	  /**
	  *@link http://us.php.net/manual/en/function.curl-setopt.php
	  */
	  //something related to CURLOP_SSL_VERIFYPEER, and validating certs from local a local path
	  if (defined("CURL_CA_BUNDLE_PATH")) curl_setopt($ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH);
	  
	  //sets the url we are going to make a request from
	  //this is the full $url from the function call
	  curl_setopt($ch, CURLOPT_URL, $url);
	  
	  //The number of seconds to wait whilst trying to connect. Use 0 to wait indefinitely
	  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
	  
	  //The maximum number of seconds to allow cURL functions to execute.
	  curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	  
	  //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
	  //setup the headers
	  $h =  array();
	  foreach($headers as $k => $v){
		  $h[] = $k . ": " . $v;
	  }
	  
	  curl_setopt($ch, CURLOPT_HEADER, true);
	  
	  //ok, now we need to worry about POST, and PUTs
	  switch($method){
	  	case 'GET':
			//we do not need to do anything
			break;
		case 'POST':
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
			//The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. This can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyContent);
			//does this work with UTF-8 chars?
			//$h[] = 'Content-Length: ' . strlen($bodyContent);
			break;
		case 'PUT':
			//if we are going to put a file, 
			//this needs to be done differently
			//this is designed for small url encoded strings
			
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
			//The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. This can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value.
			curl_setopt($ch, CURLOPT_POSTFIELDS, $bodyContent);
			//$h[] = 'Content-Length: ' . strlen($bodyContent);
			break;
		case 'DELETE':
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
			break;
	  }
	  
	  self::dump("\r\n" . '::Sent Headers::' . "\r\n" . implode("\r\n", $h));
	  curl_setopt($ch, CURLOPT_HTTPHEADER, array( implode("\r\n", $h) ) );
	  
	  
	  $Twitter_response = curl_exec($ch);
	  
	  $responseBody 	= '';
	  $responseHeader 	= '';
	  
	  list($responseHeader, $responseBody) = explode("\r\n\r\n", $Twitter_response, 2);
	  
	  $responseStatus 		= (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
	  $responseContentType 	= curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
	  
	  //if a content type was found
	  if ($responseContentType) {
		  $responseContentType = preg_replace(
										  "/;.*/", 
										  "", 
										  $responseContentType
										  ); // strip off charset
	  }
	  
	  
	  $response = array(
		  			'contentType' => $responseContentType,
					'status' => $responseStatus,
					'headers' => $responseHeader,
					'body' => $responseBody,
					'raw' => $Twitter_response
					);
	  
	  return $response;
  }
  
  
  
 

  /** Format and sign an OAuth / API request
   * @param 	$url
   * @param 	$args
   * @param 	$method
   *
   * */
  function oAuthRequest($url, $args=array(), $method=NULL) {
  /*
  @TODO: args do not make this a GET vs, POST, vs PUT, vs DELETE
  */
    if (empty($method)) $method = empty($args) ? "GET" : "POST";

    $req = OAuthRequest::from_consumer_and_token(
	    				$this->consumer,
	    				$this->token,
	    				$method,
	    				$url,
	    				$args);

    $req->sign_request($this->sha1_method, $this->consumer, $this->token);
    
    //for debuging later, writes the request to a file if configured
    if (self::$TW_DUMP_REQUESTS) {

      $k = $this->consumer->secret . "&";

      if ($this->token) $k .= $this->token->secret;

      date_default_timezone_set('UTC');
      $reqTime = date('c',time());
      
      $dump = ''; //clear dump
      $dump = "---\n\nOAUTH REQUEST TO $url";
      $dump .= "\n TIME:".$reqTime."  \n\n";
      
      if (!empty($args)){ $dump .= " WITH PARAMS: " . json_encode($args); }
      $dump .= 	"\n\nBase string: " . $req->base_string . 
      		"\nSignature string: $k\n";
		
      self::dump($dump);
      
      $dump =''; //clear dump

    }//end debug dump
    
    
    switch ($method) {
	    case 'GET':
	    	return $this->http($req->to_url());
	    	break;
	    case 'POST':
	    	return $this->http($req->get_normalized_http_url(),
				   $req->to_postdata());
	    	break;
    }
  }

  /**
   *  Make an HTTP request, throwing an exception if we get anything other than a 200 response
   * @param 	$url
   * @param 	$postData
   *
   * @return	$response
   * */
  public function http($url, $postData=null) {
    if (self::$TW_DUMP_REQUESTS) {

      self::dump("Final URL: $url\n\n");

      $url_bits = parse_url($url);

      if (isset($postData)) {

		self::dump(
			"POST ".$url_bits['path']." HTTP/1.0".
			"\nHost: ".$url_bits['host'].
			"\nContent-Type: application/x-www-form-urlencoded".
			"\nContent-Length: ".strlen($postData).
			"\n\n$postData\n"
			);

      }
      else {

		$get_url = $url_bits['path'];

		if ($url_bits['query']) $get_url .= '?' . $url_bits['query'];

		self::dump(
			"GET $get_url HTTP/1.0".
			"\nHost: ".$url_bits['host'].
			"\n\n"
			);

      }
    }// end if ms_dump_requests

    $ch = curl_init();

    if (defined("CURL_CA_BUNDLE_PATH")) curl_setopt($ch, CURLOPT_CAINFO, CURL_CA_BUNDLE_PATH);

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, true);

    if (isset($postData)) {
	  //TRUE to do a regular HTTP POST. This POST is the normal application/x-www-form-urlencoded kind, most commonly used by HTML forms
      curl_setopt($ch, CURLOPT_POST, true);
	  //The full data to post in a HTTP "POST" operation. To post a file, prepend a filename with @ and use the full path. This can either be passed as a urlencoded string like 'para1=val1&para2=val2&...' or as an array with the field name as key and field data as value.
      curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    }

    $data = curl_exec($ch);
    $response = '';
    list($header, $response) = explode("\r\n\r\n", $data, 2);
    
    $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $ct = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

    if ($ct) $ct = preg_replace("/;.*/", "", $ct); // strip off charset

    if (self::$TW_DUMP_REQUESTS) {
      self::dump("\n____RAW RESPONSE____\n$data\n____END RAW RESPONSE___\n\n");
    }
    
    if (!$status) throw new TwitterException(
	    			"Connection to $url failed:<br/><br/>\r\n\r\n".
	      			"Response:<br/><br/>\r\n".
				$data, TwitterException::CONNECT_FAILED);
/**
*@link http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
* not all responses are supported by the Twitter REST API
*
*@link http://developerwiki.Twitter.com/index.php?title=Twitter_REST_Resources
*
*@link http://oauth.pbwiki.com/ProblemReporting
*
** 1xx **Informational
*  100 Continue
*  101 Switching Protocols
** 2xx **Success
*  200 status OK	**OK
*  201 created		**Created OK
*  202 accepted
*  203 non-authoritative information
*  204 No Content
*  205 reset content
*  206 partial content
*  207 multi-status
** 3xx **Redirection
*  300 multiple choices?  mime type?
*  301 moved peranetly
*  302 found
*  303 Redirect See Other
*  304 not modified (GET, HEAD, cache response)		**No Changes
*  305 use proxy (clients usually do not support this)
*  306 switch proxy (no longer used)
*  307 moved temporarily
** 4xx **Client Error
*  400 bad request
*  401 unauthorized		**unauthorized
*  402 payment required
*  403 forbidden
*  404 Not Found
*  405 Method Not Allowed (check GET, POST, PUT, DELETE, HEAD, TRACE)
*  406 not acceptable
*  407 proxy authenticatio required
*  408 request timeout
*  409 Conflict		**Conflict
*  410 Gone
*  411 lenth required
*  412 Precondition Failed
*  413 Request Entity Too Large
*  414 request URI too long
*  415 Unsupported media type
*  416 requested rante not satisfiable
*  417 exception failed
*  418 I'm a teapot
*  500 internal server error
*  501 not implmented			**internal server error
*  502 bad gateway
*  503 service unavailable		**server too busy
*  504 gateway timeout
*  505 http version not supported
*  506 variant also negotiates
*  507 insufficient storage
*  509 bandwidth limit exceeded
*  510 not extended
*/
    //things were not perfect, let's throw an error
    if ($status != 200) {
	//redirects should be valid REST responses!
	    
      switch($status){
	      
      	case 201:
		//i remember seeing this once before
		break;
      	case 401:
			/*  consumer key is not set!! or is wrong
	  Fatal error: Uncaught exception 'TwitterException' with message 'Request to http://api.Twitter.com/request_token?oauth_version=1.0&oauth_nonce=9a5139f46cb96314a7d5a3faf6ee95ca&oauth_timestamp=1238041272&oauth_consumer_key=NOT%20SET&oauth_signature_method=HMAC-SHA1&oauth_signature=8RqzekFfhFmAsXAql3RHJTX9A%2Fc%3D failed:<br/><br/> HTTP error 401 <br/><br/> Response:<br/><br/> HTTP/1.1 401 oauth_problem=consumer_key_unknown Date: Thu, 26 Mar 2009 04:21:12 GMT Server: Microsoft-IIS/6.0 WWW-Authenticate: OAuth realm="http://api.Twitter.com/authorization", oauth_problem=consumer_key_unknown Set-Cookie: MSCulture=IP=208.113.234.71&IPCulture=en-US&PreferredCulture=en-US&PreferredCulturePending=&Country=VVM=&ForcedExpiration=633736128723757790&timeZone=0&myStuffDma=&USRLOC=QXJlYUNvZGU9NzE0JkNpdHk9QnJlYSZDb3VudHJ5Q29kZT1VUyZDb3VudHJ5TmFtZT1Vbml0ZWQgU3RhdGVzJkRtYUNvZGU9ODAzJkxhdGl0dWRlPTMzLjkyNjkmTG9uZ2l0dWRlPS0xMTcuODYxMiZQb3N0YWxDb2RlPTkyODIxJlJlZ2lvbk5hbWU9Q0E=; domain=.Twitter.com; expires=Sat, 25-Apr-2009 04:21:12 GMT in /home/.jamshid/user1056/demos.jdavid.net/Twitterid-sdkv03252009/source/TwitterID/Twitter.php on line 1197
	  */
		//suspended app
		//insuffecient app permission
		//insuffecient user or application permission
		//incorrect user
		//missing or revoked token
		//insuffecient OpenCanvace Permissions
		//user has not added app
		//expired timestamp
		break;
      	case 403:
		//missing oauth params
		//expired timestamp
		//used nonce
		
		//invalid key
		
		//invalid token
		
		//invalid key
		/*
		It seems like the openid realm entered in the application page needs
		to have a trailing slash to work properly.  If that’s the case, we
		really need to either add it ourselves or warn the user when they
		enter it.  Also, when the realm doesn’t match, we return:
		
		403 "Neither the token nor the cookie is present to complete this call."
		*/
		break;
	case 404:
		//the resource is not found
		//missing user
		break;
      	case 500:
		//this is likely to be a realm mismatch error, but it could be something else
		break;
      }
      
      /**
      *  Response types
      *
      *  application/x-www-form-urlencoded
      *  application/json
      *  application/atom+xml
      */
      
      //ok, so its an unexpected error type, find the content type and throw a general error
      if ($ct == "application/json") {
		$r = json_decode($response);
		if ($r && isset($r->rsp) && $r->rsp->stat != 'ok') {

		  throw new TwitterException($r->rsp->code.": ".$r->rsp->message."\r\n\r\n<br /><br /><pre>\r\n$header\r\n</pre>",
		  				TwitterException::REMOTE_ERROR, $r->rsp);

		}
      }
      if ($ct == "application/atom+xml") {
	      	//we must have asked for an XML or ATOM doc type, but something went wrong
		$r = new SimpleXMLElement($response);

      }

      
      //throw a general error
      throw new TwitterException(
	      			"Request to $url failed:<br/><br/>\r\n\r\n".
	      			"HTTP error $status <br/><br/>\r\n".
				"Response:<br/><br/>\r\n".
				$data,
      				TwitterException::REQUEST_FAILED, $response);
    }
    curl_close ($ch);

    return $response;
  }
  
  /**
   * checks if token is present, else throws an exception
   *
   * */
  protected function requireToken() {
    if (!isset($this->token)) {
      throw new TwitterException(
      				"This function requires an OAuth token",
      				 TwitterException::TOKEN_REQUIRED
      				 );
    }
  }
  
  /**
  *
  *
  */
  private function isSupportedMethod($method, $raiseException=false){
	  $value = false;
	  
	  //we will add support DELETE later
	  //HEAD, TRACE, etc... are NOT supported
	  $supported = array('GET','PUT','POST');
	  
	  $value = in_array($method, $supported, true);
	  
	  if($raiseException && $value == false){
		  //raise exceptions
	  }
	  
	  return $value;
  }
  
  /**
  *
  *
  */
  private function isSupportedRequestContentType($contentType, $raiseException=false){
	  $value = false;
	  $supported = array(
		  'application/x-www-form-urlencoded'
		  );
	  
	  $value = in_array( $contentType, $supported, true);
	  
	  //if $contentType = multi-part message throw different error
	  
	  if($raiseException && $value == false){
		  //raise exceptions
	  }
	  
	  return $value;
  }
  
  /**
  *
  *
  */
  private function isSupportedResponseContentType($contentType){
	  $value = false;
	  $supported = array(
		  'application/x-www-form-urlencoded',
		  'application/json',
		  'application/xml',
		  'application/atom+xml');
	  
	  $value = in_array($contentType, $supported, true);
	  
	  //if $contentType = multi-part message throw different error
	  
	  if($value == false){
		  //raise exceptions
	  }
	  
	  return $value;
  }
  

  /**
   * writes to an error log
   *
   * @param string $text
   */
  private function dump($text) {
    if (!self::$TW_DUMP_REQUESTS) throw new Exception(
    	'Twitter::$TW_DUMP_REQUESTS must be set to enable request trace dumping');

    file_put_contents(self::$TW_DUMP_REQUESTS, $text, FILE_APPEND);

  }

}
}
?>
