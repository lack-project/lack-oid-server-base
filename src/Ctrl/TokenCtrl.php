<?php


namespace Lack\OidServer\Base\Ctrl;


use Lack\OidServer\Base\Manager\TokenManagerInterface;
use Lack\OidServer\Base\Type\T_Q_Token;
use Lack\OidServer\Base\Type\T_R_Token;

class TokenCtrl
{


    /**
     *
     *
     * @see https://auth0.com/docs/api/authentication#authorization-code-flow45
     * @param T_R_Token $body
     * @param TokenManagerInterface $tokenManager
     */
    public function __invoke(T_Q_Token $body, TokenManagerInterface $tokenManager)
    {
        $authReq = $tokenManager->getByCode($body->code);

        return [
            "token" => $authReq->client_id
        ];

    }

}
