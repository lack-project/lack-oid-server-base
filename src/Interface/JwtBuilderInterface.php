<?php


namespace Lack\OidServer\Base\Interface;


interface JwtBuilderInterface
{

    public function getExpiresIn() : int;
    public function buildJwtToken(array $claims) : string;

}
