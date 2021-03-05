<?php


namespace Lack\OidServer\Base\Manager;


interface TenantConfigInterface
{
    /**
     * The url to redirect to after successfull login attempt where
     * where no auth request is pending (direct link to signin page)
     *
     * @return string
     */
    public function getDefaultLocationUri() : string;
}
