<?php


namespace Lack\OidServer\Base\Manager;


interface ClientReadManagerInterface
{

    public function getClientById(string $clientId) : ClientInterface;
}
