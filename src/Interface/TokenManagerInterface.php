<?php


namespace Lack\OidServer\Base\Interface;


use Lack\OidServer\Base\Type\T_Q_Authorize;

interface TokenManagerInterface
{

    

    public function storeCode(string $code, T_Q_Authorize $authorize);

    public function getByCode(string $code) : ?T_Q_Authorize;
}
