<?php


namespace Lack\OidServer\Base\Interface;


interface ClaimManagerInterface
{

    public function getScopes(ClientInterface $client, UserInterface $user = null, array $scopes = []) : array;

}
