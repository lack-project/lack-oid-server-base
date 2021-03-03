<?php


namespace Lack\OidServer\Base\Manager;


interface ClientInterface
{
    public function isValidSecret(string $secret) : bool;

    public function isValidRedirectTarget(string $url) : bool;
}
