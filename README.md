# Evance APIs Client Library for PHP
A PHP client library for accessing Evance APIs

## Work in progress!
This library is currently a work in progress. It is therefore subject
to dramatic changes. 

## Requirements
PHP 8.0 or higher 

## Installation
You can use **Composer** (our preferred method) or download the source.

### Composer
Once you have [installed composer](https://getcomposer.org), execute the following 
command in your project root to install this library:

```sh
composer require evance/apiclient
```

You should ensure you have included the autoloader for your project:

```php
require_once '/path/to/your-project/vendor/autoload.php';
```

### Download
At the moment we do not have a release complete with its dependencies - it'll be coming soon. 


## Examples

### Authentication with OAuth 2.0
This method is for Web Clients requiring user authorisation. Follow the steps below to obtain
an access token from Evance.

1. Create your App and credentials.

1. Download the JSON credentials and save them into a configuration directory within you project.

1. Set the path to your credentials as below:
    ```php
    use Evance\ApiClient;
    $client = new ApiClient();
    $client->loadAuthConfig('/path/to/client-credentials.json');
    ```

1. Set the scopes required for the API you are going to call. 
    ```php
    $client->addScope('shipping');
    ```

1. Set your application's redirect URI. The redirect URI must match the authorised redirect URI 
you set when creating your client credentials.
    ```php
    $client->setRedirectUri('https://example.com/callback');
    ```

1. Set a use-once state number. This number will be returned to your callback page so that you
may confirm you sent the original request. Therefore, you will need to ensure you can persist
the number to the callback page. This may done, for example, within a session variable. 
    ```php
    $client->setState($nonce);
    ```

1. Get the Evance OAuth 2.0 URL for a user to authorise access. You can either use this URL in
redirect or provide a link for the user to click.
    ```php
    $url = $client->createAuthorizeUrl();
    ```
    
1. In the callback script (your redirect URI), you will need to exchange the authorisation code
for an access token. You should also verify that **state** is as expected. 
    ```php
    $token = $client->authenticate($_GET);
    ```
    
### Authenticating Server-to-server clients
This method is for obtaining single use access tokens. Unlike Web Clients a Server Key
does not have a refresh token so a new access token must be obtained every time a token expires.

1. Create your App and credentials.

1. Download the JSON credentials and save them into a configuration directory within you project.

1. Set the path to your credentials as below:
    ```php
    use Evance\ApiClient;
    $client = new ApiClient();
    $client->loadAuthConfig('/path/to/server-credentials.json');
    ```

1. Optionally, you may set the scope you wish to grant the access token. Omitting this step
will grant the access token full access to the scopes granted to your App. 
    ```php
    $client->addScope('shipping');
    ```
    
1. Now you can obtain the access token from Evance. 
    ```php
    $token = $client->fetchAccessTokenWithJwt();
    ```


