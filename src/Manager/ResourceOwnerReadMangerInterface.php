<?php


namespace Lack\OidServer\Base\Manager;


interface ResourceOwnerReadMangerInterface
{

    public function getResourceOwnerById(string $uid) : ResourceOwnerInterface;

    public function findResourceOwner(string $uidOrEMail) : ResourceOwnerInterface;

}
