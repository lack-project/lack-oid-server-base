<?php


namespace Lack\OidServer\Base\Interface;


interface ClientInterface
{
    public function isValidSecret(string $secret) : bool;

    public function isValidRedirectTarget(string $url) : bool;
}
