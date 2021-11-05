<?php


namespace Lack\OidServer\Base\Interface;


interface ClientInterface
{
    
    public function getClientId(): string;
    
    public function isValidSecret(string $secret) : bool;

    public function isValidRedirectTarget(string $url) : bool;
    
    
}
