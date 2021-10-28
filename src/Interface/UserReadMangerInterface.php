<?php


namespace Lack\OidServer\Base\Interface;


use Phore\Core\Exception\NotFoundException;

interface UserReadMangerInterface
{

    /**
     * @param string $uid
     * @return ResourceOwnerInterface
     * @throws NotFoundException
     */
    public function getResourceOwnerByUid(string $uid) : UserInterface;

    /**
     * @param string $uidOrEMail
     * @return ResourceOwnerInterface
     * @throws NotFoundException
     */
    public function findResourceOwner(string $uidOrEMail) : UserInterface;

}
