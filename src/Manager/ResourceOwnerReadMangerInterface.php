<?php


namespace Lack\OidServer\Base\Manager;


use Phore\Core\Exception\NotFoundException;

interface ResourceOwnerReadMangerInterface
{

    /**
     * @param string $uid
     * @return ResourceOwnerInterface
     * @throws NotFoundException
     */
    public function getResourceOwnerById(string $uid) : ResourceOwnerInterface;

    /**
     * @param string $uidOrEMail
     * @return ResourceOwnerInterface
     * @throws NotFoundException
     */
    public function findResourceOwner(string $uidOrEMail) : ResourceOwnerInterface;

}
