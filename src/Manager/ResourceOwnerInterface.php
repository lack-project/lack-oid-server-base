<?php


namespace Lack\OidServer\Base\Manager;


interface ResourceOwnerInterface
{

    public function getUid() : string;
    public function isValidSecret(string $secret) : bool;

}
