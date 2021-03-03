<?php


namespace Lack\OidServer\Base\Manager;


interface ResourceOwnerInterface
{

    public function isValidSecret(string $secret) : bool;

}
