<?php

namespace Evance\Auth;
use Evance;
use GuzzleHttp\Psr7;
use Firebase\JWT\JWT;

class OAuth2{
	
	const DEFAULT_EXPIRY_SECONDS = 3600; // 1 hour
    const DEFAULT_SKEW_SECONDS = 60; // 1 minute
    const JWT_URN = 'urn:ietf:params:oauth:grant-type:jwt-bearer';
	
	private $config;
	
	public static $grantTypes = array(
		'authorization_code',
		'refresh_token',
		'password',
		'client_credentials'
	);
	
	public static $algorithms = array(
        'HS256' => array('hash_hmac', 'SHA256'),
        'HS512' => array('hash_hmac', 'SHA512'),
        'HS384' => array('hash_hmac', 'SHA384'),
        'RS256' => array('openssl', 'SHA256'),
    );
	
	private $code;
	private $grantType;
	
	public function __construct(array $config=array()) {
		$this->config = new Evance\ConfigManager([
			'expiry' => self::DEFAULT_EXPIRY_SECONDS,
			'authorize_uri' => null,
			'token_uri' => null,
			'state' => null,
			'username' => null,
			'password' => null,
			'client_id' => null,
			'client_secret' => null,
			'issuer' => null,
			'private_key' => null,
			'algorithm' => 'HS256',
			'scope' => null
		]);
		$this->config->merge($config);
	}
	
	public function createAuthorizeUri(array $config=array()){
		if(is_null($this->getAuthorizeUri())){
			throw new \InvalidArgumentException('Missing config authorize_uri');
		}
		$params = array_merge([
			'response_type' => 'code',
			'access_type' => 'offline',
			'client_id' => $this->getClientId(),
			'redirect_uri' => $this->getRedirectUri(),
			'state' => $this->getState(),
			'scope' => $this->getScope()
		], $config);
		// require certain properties
		if(is_null($params['client_id'])){
			throw new \InvalidArgumentException('Missing config client_id');
		}
		if(is_null($params['redirect_uri'])){
			throw new \InvalidArgumentException('Missing config redirect_uri');
		}
		$url = new Psr7\Uri($this->getAuthorizeUri());
		$existingParams = Psr7\parse_query($url->getQuery());
        $url = $url->withQuery(
            Psr7\build_query(array_merge($existingParams, $params))
        );
		if($url->getScheme() != 'https'){
			throw new \InvalidArgumentException('Authorization endpoint must be over TLS');
		}
		return $url;
	}
	
	public function fetchAccessTokenWithAuthCode($code){
		$uri = $this->getTokenUri();
		$params = [
			'grant_type' => 'authorization_code',
			'code' => $code
		];
		$headers = [
            'Cache-Control' => 'no-store',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
		$client = new \GuzzleHttp\Client([
			'verify' => false, // @todo remove before going live
            'auth' => [$this->getClientId(), $this->getClientSecret()]
		]);
		try{
			$response = $client->request('POST', $uri, [
				'headers' => $headers,
				'form_params' => $params
			]);
		} catch(\GuzzleHttp\Exception\ClientException $e){
			$response = $e->getResponse();
		}
		$body = $response->getBody()->getContents();
		$token = json_decode($body, true);
		if(!$token){
		    var_dump($body);
			throw new \Exception('Malformed response from server');
		}
		if(isset($token['error'])){
			throw new \Exception($token['error_description']);
		}
		return $token;
	}

	public function fetchAccessTokenWithJwt()
    {
        $uri = $this->getTokenUri();
        $params = [
            'grant_type' => self::JWT_URN,
            'assertion' => $this->toJwt()
        ];
        $headers = [
            'Cache-Control' => 'no-store',
            'Content-Type' => 'application/x-www-form-urlencoded'
        ];
        $client = new \GuzzleHttp\Client([
            'verify' => false // @todo remove before going live
        ]);
        try{
            $response = $client->request('POST', $uri, [
                'headers' => $headers,
                'form_params' => $params
            ]);
        } catch(\GuzzleHttp\Exception\ClientException $e){
            $response = $e->getResponse();
        }
        $body = $response->getBody()->getContents();
        $token = json_decode($body, true);
        if(!$token){
            var_dump($body);
            throw new \Exception('Malformed response from server');
        }
        if(isset($token['error'])){
            throw new \Exception($token['error_description']);
        }
        return $token;
    }

	
	public function getAuthorizeUri(){
		return $this->config->get('authorize_uri');
	}
	
	public function getClientId(){
		return $this->config->get('client_id');
	}
	
	public function getClientSecret(){
		return $this->config->get('client_secret');
	}
	
	public function getCode(){
		return $this->code;
	}
	
	public function getRedirectUri(){
		return $this->config->get('redirect_uri');
	}
	
	public function getScope(){
		return $this->config->get('scope');
	}
	
	public function getState(){
		return $this->config->get('state');
	}
	
	public function getSigningAlgorithm(){
		return $this->config->get('algorithm');
	}
	
	public function getSigningKey(){
		return $this->config->get('private_key');
	}
	
	public function getTokenUri(){
		return $this->config->get('token_uri');
	}
	
	public function setCode($code){
		$this->code = $code;
	}

    public function toJwt(){

        $algorithm = $this->getSigningAlgorithm();
        $privateKey = $this->getSigningKey();

        // @todo: scopes
        $payload = [
            'aud' => $this->getTokenUri(),
            'exp' => strtotime('now + 1 hour'),
            'iat' => time(),
            'scope' => '', // @todo scopes have not been defined yet
            'sub' => $this->getClientId(),
            'iss' => $this->getClientId()
        ];

        return JWT::encode($payload, $privateKey, $algorithm);
    }
	
	// todo: this needs to go into JWT really
	public function sign($message){
		$algorithmKey = $this->getSigningAlgorithm();
		$key = $this->getSigningKey();
		if(empty($algorithmKey)){
			throw new \Exception('Missing algorithm in config');
		}
		if(empty($key)){
			throw new \Exception('Missing private_key in config');
		}
		if (empty(static::$algorithms[$algorithmKey])) {
            throw new \Exception('Algorithm not supported');
        }
        list($function, $algorithm) = static::$algorithms[$algorithmKey];
        switch($function) {
            case 'hash_hmac':
                return hash_hmac($algorithm, $message, $key, true);
            case 'openssl':
                $signature = '';
                $success = openssl_sign($msg, $signature, $key, $algorithm);
                if (!$success) {
                    throw new DomainException("OpenSSL unable to sign data");
                } else {
                    return $signature;
                }
        }
	}
	// todo: this needs to go into JWT really
	public function verify($message, $signature){
		$signed = $this->sign($message);
		return (base64_encode($signed) == $signature);
	}

}
