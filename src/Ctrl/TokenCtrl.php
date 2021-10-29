<?php


namespace Lack\OidServer\Base\Ctrl;

use Brace\Core\BraceApp;
use Lack\OidServer\Base\Flows\AuthorizationCodePKCE;
use Lack\OidServer\Base\Interface\TokenManagerInterface;
use Lack\OidServer\Base\Type\T_Q_Token;

class TokenCtrl
{


    /**
     *
     *
     * @see https://auth0.com/docs/api/authentication#authorization-code-flow45
     * @param T_R_Token $body
     * @param TokenManagerInterface $tokenManager
     */
    public function __invoke(BraceApp $app, T_Q_Token $body, TokenManagerInterface $tokenManager)
    {
        // Load the original AuthRequest previously sent to /authorize endpoint
        $origAuthReq = $tokenManager->getByCode($body->code);


        if ($body->grant_type === "authorization_code" && $body->code_verifier !== null) {
            $flow = new AuthorizationCodePKCE();
            return $flow->process($app, $body, $origAuthReq);
        }

        return [
            "token" => $authReq->client_id
        ];

    }

}
