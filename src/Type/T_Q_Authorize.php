<?php


namespace Lack\OidServer\Base\Type;

/**
 * Class T_Q_Authorize
 *
 * This Class represents the query parameters submitted to the /authorize endpoint (GET)
 *
 * @package Lack\OidServer\Base\Type
 */
class T_Q_Authorize
{
    /**
     * The System this key is created for.
     *
     * @var string|null
     */
    public $audience = null;

    /**
     * @var string
     */
    public $client_id;

    /**
     * @var string|null
     */
    public $client_secret = null;

    /**
     * @var string
     */
    public $response_type;

    /**
     * @var string|null
     */
    public $redirect_uri;

    /**
     * @var string|null
     */
    public $scope = null;


    /**
     * @var string|null
     */
    public $state = null;

    /**
     * If set to 'none' don't prompt for user interactions
     * and return error if request not possible
     *
     * @var string|null
     */
    public $prompt = null;


    /**
     * Required for PKCE Flow
     *
     * @var string|null
     */
    public $code_challenge_method;

    /**
     * Required for PKCE Flow
     *
     * @var string|null
     */
    public $code_challenge;

}
