<?php


namespace Lack\OidServer\Base\Interface;


interface ClaimManagerInterface
{

    public function getScopes(ClientInterface $client, ResourceOwnerInterface $resourceOwner = null, array $scopes = []) : array;

}
