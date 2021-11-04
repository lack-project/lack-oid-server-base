<?php


namespace Lack\OidServer\Base\Ctrl;

use Brace\Core\BraceApp;
use Brace\Session\Session;
use Lack\OidServer\Base\Flows\AuthorizationCodePKCE;
use Lack\OidServer\Base\Interface\ClaimManagerInterface;
use Lack\OidServer\Base\Interface\ClientReadManagerInterface;
use Lack\OidServer\Base\Interface\JwtBuilderInterface;
use Lack\OidServer\Base\Interface\TokenManagerInterface;
use Lack\OidServer\Base\Interface\UserReadMangerInterface;
use Lack\OidServer\Base\OidApp;
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

        sleep(1);


        if ($body->grant_type === "authorization_code" && $body->code_verifier !== null) {
            $flow = new AuthorizationCodePKCE();
            $origAuthReq = $tokenManager->getByCode($body->code);

            $flow->validate($app, $body, $origAuthReq);

            $claimManager = $app->get("claimsManager", ClaimManagerInterface::class);
            $jwtBuilder = $app->get("jwtBuilder", JwtBuilderInterface::class);
            $clientManager = $app->get("clientReadManager", ClientReadManagerInterface::class);
            $userManager = $app->get("userReadManager", UserReadMangerInterface::class);

            $loginUid = $app->get("session", Session::class)->get(OidApp::SESS_KEY_LOGIN_UID);
            $user = $userManager->getUserByUid($loginUid);

            $token = $jwtBuilder->buildJwtToken(
                $claimManager->getScopes(
                    $clientManager->getClientById($origAuthReq->client_id),
                    $user,
                    explode(" ", $origAuthReq->scope)
                )
            );

            return [
                "access_token" => $token,
                "expires_in" => $jwtBuilder->getExpiresIn()
            ];

        } else {

        }

        return [
            "token" => $authReq->client_id
        ];

    }

}
