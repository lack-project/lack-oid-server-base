<?php


namespace Lack\OidServer\Base\Type;


class T_Q_Authorize
{
    /**
     *
     *
     * @var string|null
     */
    public $grant_type = null;

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
    public $audience;

    /**
     * @var string|null
     */
    public $state = null;
}
