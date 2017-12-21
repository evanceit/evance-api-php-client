<?php

namespace Evance;

use Evance;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Firebase\JWT\JWT;

class ApiClient
{

    const VERSION = "0.0.1-alpha";
	const OAUTH2_TOKEN_URI = 'https://{account}/admin/oauth/token';
	const OAUTH2_REVOKE_URI = 'https://{account}/admin/oauth/revoke';
	const OAUTH2_AUTH_URL = 'https://{account}/admin/oauth/authorize';
	const API_BASE_PATH = 'https://{account}/api';
    const USER_AGENT_SUFFIX = "evance-api-php-client/";
	
	private $config;
	private $scopes = [];
	private $auth;
	private $accessToken;
	private $http;
	
	public function __construct(array $config = [])
    {
		$this->config = new Evance\ConfigManager([
			'account' => '',
            'app_name' => '',
            'approval_prompt' => 'auto',
			'client_id' => '',
			'client_secret' => '',
			'redirect_uri' => '',
			'state' => '',
			'private_key' => null,
			'algorithm' => 'HS256'
		]);
		$this->config->merge($config);
	}

    /**
     * @param $scope
     * @return $this
     */
	public function addScope($scope)
    {
        $this->scopes[] = $scope;
        return $this;
	}

    /**
     * @param $params
     * @return bool|mixed
     */
	public function authenticate($params)
    {
	    if(!$this->verifyAuthorizeCallback($params)){
	        return false;
        }
        return $this->fetchAccessTokenWithAuthCode($params['code']);
    }

    /**
     * @param ClientInterface|null $http
     * @return Client|ClientInterface
     * @throws \Exception
     */
    public function authorize(ClientInterface $http = null)
    {
        $credentials = null;
        $token = null;
        $scopes = null;
        if (is_null($http)) {
            $http = $this->getHttpClient();
        }

        if ($token = $this->getAccessToken()) {
            $scopes = $this->prepareScopes();
            // add refresh subscriber to request a new token
            if ($this->hasAccessTokenExpired() && isset($token['refresh_token'])) {
                // @ todo: replace with a more elegant solution
                throw new \Exception('Access token has expired');
            }
        }
        return $http;
    }

    /**
     * @return Auth\OAuth2
     */
	public function createOAuth2Service()
    {
		$auth = new Evance\Auth\OAuth2([
			'client_id' => $this->getClientId(),
			'client_secret' => $this->getClientSecret(),
			'authorize_uri' => $this->getAuthorizationUri(),
			'token_uri' => $this->getTokenUri(),
			'redirect_uri' => $this->getRedirectUri(),
			'issuer' => $this->getClientId(),
			'private_key' => $this->getConfig('private_key'),
			'algorithm' => $this->getConfig('algorithm')
		]);
		return $auth;
	}

    /**
     * @return string
     */
	public function createAuthorizeUrl()
    {
		$params = array_filter([
			'approval_prompt' => $this->getConfig('approval_prompt'),
			'response_type' => 'code',
			'scope' => $this->prepareScopes(),
			'state' => $this->getConfig('state')
		]);
		$auth = $this->getOAuth2Service();
		return (string) $auth->createAuthorizeUri($params);
	}

    /**
     * @return Client
     */
    protected function createDefaultHttpClient()
    {
        $options = [
            'exceptions' => false
        ];
        $options['base_uri'] = $this->getBaseUri();
        return new HttpClient($options);
    }

    /**
     * @return $this
     */
	public function enforceApprovalPrompt()
    {
		$this->setConfig('approval_prompt', 'force');
		return $this;
	}

    /**
     * @param RequestInterface $request
     * @return mixed
     */
    public function execute(RequestInterface $request)
    {
        $request = $request->withHeader(
            'User-Agent',
            $this->getConfig('app_name')
            . " " . self::USER_AGENT_SUFFIX
            . $this->getVersion()
        );

        $headers = [
            'Cache-Control' => 'no-store',
            'Authorization' => 'Bearer ' . $this->getAccessToken()['access_token']
        ];

        $client = new HttpClient(['verify' => false]);
        $response = $client->send($request, [
            'headers' => $headers
        ]);
        $body = (string) $response->getBody();
        $json = json_decode($body, true);

        return $json;
    }

    /**
     * @param $code
     * @return mixed
     */
	public function fetchAccessTokenWithAuthCode($code)
    {
		if(strlen($code) == 0){
			throw new \InvalidArgumentException("Invalid authorization code");
		}
		$auth = $this->getOAuth2Service();
		$response = $auth->fetchAccessTokenWithAuthCode($code);
        if ($response && isset($response['access_token'])) {
            $response['created'] = time();
            $this->setAccessToken($response);
        }
        return $response;
	}

    /**
     * @return mixed
     */
	public function fetchAccessTokenWithJwt()
    {
        $auth = $this->getOAuth2Service();
        $response = $auth->fetchAccessTokenWithJwt();
        if ($response && isset($response['access_token'])) {
            $response['created'] = time();
            $this->setAccessToken($response);
        }
        return $response;
    }

    /**
     * @return mixed
     */
	public function getAccessToken()
    {
	    return $this->accessToken;
    }

    /**
     * @return null
     */
	public function getAccount()
    {
		return $this->getConfig('account');
	}

    /**
     * @return mixed
     */
	public function getAuthorizationUri()
    {
		return $this->parseUri(self::OAUTH2_AUTH_URL);
	}

    /**
     * @return mixed
     */
	public function getBaseUri()
    {
        return $this->getResourceUri('');
    }

    /**
     * @return null
     */
	public function getClientId()
    {
		return $this->getConfig('client_id');
	}

    /**
     * @return null
     */
	public function getClientSecret()
    {
		return $this->getConfig('client_secret');
	}

    /**
     * @param $property
     * @param null $default
     * @return null
     */
	public function getConfig($property, $default=null)
    {
		return $this->config->get($property, $default);
	}

    /**
     * @return Client
     */
    public function getHttpClient()
    {
        if (is_null($this->http)) {
            $this->http = $this->createDefaultHttpClient();
        }

        return $this->http;
    }

    /**
     * @return string
     */
    public function getJwt(){

	    $algorithm = $this->getSigningAlgorithm();
	    $privateKey = $this->getSigningKey();

	    // @todo: scopes
	    $payload = json_encode([
	        'aud' => $this->getTokenUri(),
            'exp' => strtotime('now + 1 hour'),
            'iat' => time(),
            'scope' => $this->prepareScopes(),
            'sub' => $this->getClientId(),
            'iss' => $this->getClientId()
        ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);

        return JWT::encode($payload, $privateKey, $algorithm);
    }

    /**
     * @return Auth\OAuth2
     */
	public function getOAuth2Service()
    {
		if (!isset($this->auth)) {
			$this->auth = $this->createOAuth2Service();
		}
		return $this->auth;
	}

    /**
     * @return null
     */
	public function getRedirectUri()
    {
		return $this->getConfig('redirect_uri');
	}

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        if (isset($this->token['refresh_token'])){
            return $this->token['refresh_token'];
        }
    }

    /**
     * @param $relativeUrl
     * @return mixed
     */
	public function getResourceUri($relativeUrl)
    {
	    $uri = self::API_BASE_PATH . $relativeUrl;
	    return $this->parseUri($uri);
    }

    /**
     * @return null
     */
	public function getSigningAlgorithm()
    {
		return $this->getConfig('algorithm');
	}

    /**
     * @return null
     */
	public function getSigningKey()
    {
		return $this->getConfig('private_key');
	}

    /**
     * @return mixed
     */
	public function getTokenUri()
    {
		return $this->parseUri(self::OAUTH2_TOKEN_URI);
	}

    /**
     * @return string
     */
	public function getVersion()
    {
	    return self::VERSION;
    }

    /**
     * @return bool
     */
    public function hasAccessTokenExpired()
    {
        if (!$this->token) {
            return true;
        }
        $created = 0;
        if (isset($this->token['created'])) {
            $created = $this->token['created'];
        } elseif (isset($this->token['id_token'])) {
            // check the ID token for "iat"
            $idToken = $this->token['id_token'];
            if (substr_count($idToken, '.') == 2) {
                $parts = explode('.', $idToken);
                $payload = json_decode(base64_decode($parts[1]), true);
                if ($payload && isset($payload['iat'])) {
                    $created = $payload['iat'];
                }
            }
        }
        // If the token is set to expire in the next 30 seconds.
        $expired = ($created + ($this->token['expires_in'] - 30)) < time();
        return $expired;
    }

    /**
     * @param $path
     * @return $this
     */
	public function loadAuthConfig($path)
    {
		if(!file_exists($path)){
			throw new \RuntimeException("JSON Config file not found: {$path}");
		}
		// read the config file as JSON and as an associative array
		// this is the native format for the config manager
		$contents = file_get_contents($path);
		$json = json_decode($contents, true);
		if(is_null($json)){
			throw new \RuntimeException("Unexpected JSON Format in {$path}");
		}
		$this->config->merge($json);
		return $this;
	}

    /**
     * @param $uri
     * @return mixed
     */
	protected function parseUri($uri)
    {
		$account = $this->getConfig('account');
		if(empty($account)){
			throw \Exception('Missing account property in config');
		}
		$uri = str_replace('{account}', $account, $uri);
		return $uri;
	}

    /**
     * @return null|string
     */
	public function prepareScopes()
    {
		if(!count($this->scopes)){
			return null;
		}
		$scopes = implode(' ', $this->scopes);
		return trim($scopes);
	}

    /**
     * @param $token
     */
    public function setAccessToken($token)
    {
        if ($token == null) {
            throw new \InvalidArgumentException('invalid json token');
        }
        if (!isset($token['access_token'])) {
            throw new \InvalidArgumentException("Invalid token format");
        }
        $this->accessToken = $token;
    }

    /**
     * @param $account
     * @return $this
     */
	public function setAccount($account)
    {
		$this->setConfig('account', $account);
		return $this;
	}

    /**
     * @param $clientId
     * @return $this
     */
	public function setClientId($clientId)
    {
		$this->setConfig('client_id', $clientId);
		return $this;
	}

    /**
     * @param $property
     * @param $value
     * @return $this
     */
	public function setConfig($property, $value)
    {
		$this->config->set($property, $value);
		return $this;
	}

    /**
     * @param $uri
     * @return $this
     */
	public function setRedirectUri($uri)
    {
		$this->setConfig('redirect_uri', $uri);
		return $this;
	}

    /**
     * @param $state
     * @return $this
     */
	public function setState($state)
    {
		$this->setConfig('state', $state);
		return $this;
	}

    /**
     * @param $params
     * @return bool
     * @throws \Exception
     */
	public function verifyAuthorizeCallback($params)
    {
		if(!isset($params['code'])){
			throw new \Exception('Missing code query parameter');
		}
		// @ todo: verify state id is correct
		if(!isset($params['state'])){
			throw new \Exception('Missing state query parameter');
		}
        if(!isset($params['account'])){
            throw new \Exception('Missing account query parameter');
        }
		if(!$this->getAccount() && isset($params['account'])){
			$this->setAccount($params['account']);
		}
		return true;
	}
	
}