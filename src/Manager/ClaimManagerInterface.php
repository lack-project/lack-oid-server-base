<?php


namespace Lack\OidServer\Base\Manager;


interface ClaimManagerInterface
{

    public function getScopes(ClientInterface $client, ResourceOwnerInterface $resourceOwner = null, array $scopes = []) : array;

}
