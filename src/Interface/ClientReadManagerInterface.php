<?php


namespace Lack\OidServer\Base\Interface;


interface ClientReadManagerInterface
{

    public function getClientById(string $clientId) : ClientInterface;
}
