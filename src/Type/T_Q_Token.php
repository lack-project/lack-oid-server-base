<?php


namespace Lack\OidServer\Base\Type;


class T_Q_Token
{
    public $grant_type;
    public $code_verifier;
    public $code;
    public $client_id;
    public $client_secret;
    public $redirect_uri;
}
