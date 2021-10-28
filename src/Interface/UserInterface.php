<?php


namespace Lack\OidServer\Base\Interface;


interface UserInterface
{

    public function getUid() : string;
    public function isValidSecret(string $secret) : bool;

}
