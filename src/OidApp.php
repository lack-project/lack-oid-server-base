<?php


namespace Lack\OidServer\Base;


use Brace\Core\BraceApp;
use Lack\OidServer\Base\Manager\ClaimManagerInterface;
use Lack\OidServer\Base\Manager\ClientReadManagerInterface;
use Lack\OidServer\Base\Manager\ResourceOwnerReadMangerInterface;
use Lack\OidServer\Base\Manager\TenantConfigInterface;
use Lack\OidServer\Base\Manager\TokenManagerInterface;

/**
 * Class OidApp
 * @package Lack\OidServer\Base
 * @property-read ResourceOwnerReadMangerInterface $resourceOwnerReadManager
 * @property-read ClientReadManagerInterface $clientReadManager
 * @property-read ClaimManagerInterface $claimManager
 * @property-read TokenManagerInterface $tokenManager
 * @property-read TenantConfigInterface $tenantConfig
 */
class OidApp extends BraceApp
{
    const SESS_KEY_LOGIN_UID = "login_uid";
    const SESS_KEY_LAST_AUTH_REQ = "last_auth_req";
}
