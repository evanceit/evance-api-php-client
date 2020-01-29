<?php

namespace Evance\Auth;

class Encryptor
{
    /** @var string */
    private $privateKeyPath;

    /** @var string */
    private $publicKeyPath;

    /**
     * Encryptor constructor.
     * @param string $publicKeyPath The filepath to the public PEM file.
     * @param string $privateKeyPath The filepath to the private PEM file.
     */
    public function __construct(
        $publicKeyPath = '/var/www/api.portal.christiesportal.com/config/public.pem',
        $privateKeyPath = '/var/www/api.portal.christiesportal.com/config/private.pem'
    ) {
        $this->publicKeyPath = $publicKeyPath;
        $this->privateKeyPath = $privateKeyPath;
    }

    /**
     * @param string $data
     * @return string
     */
    public function encrypt($data)
    {
        $pem = file_get_contents($this->privateKeyPath);
        $privateKey = openssl_get_privatekey($pem);
        openssl_private_encrypt($data, $encrypted, $privateKey);
        return base64_encode($encrypted);
    }

    /**
     * @param string $data
     * @return string
     */
    public function decrypt($data)
    {
        $pem = file_get_contents($this->publicKeyPath);
        $publicKey = openssl_get_publickey($pem);
        $decoded = base64_decode($data);
        openssl_public_decrypt($decoded, $decrypted, $publicKey);
        return $decrypted;
    }
}