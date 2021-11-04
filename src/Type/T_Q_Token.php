<?php


namespace Lack\OidServer\Base\Type;


class T_Q_Token
{
    public string $grant_type;

    /**
     * @var string|null 
     */
    public ?string $code_verifier;

    /**
     * @var string|null 
     */
    public ?string $code;
    public string $client_id;

    /**
     * @var string|null 
     */
    public ?string $client_secret = null;
    
    /**
     * @var string|null 
     */
    public ?string $redirect_uri;
}
