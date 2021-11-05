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


    private function buildToken()


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

        $user = null;
        $scopes = [];

        if ($body->grant_type === "authorization_code" && $body->code_verifier !== null) {
            $flow = new AuthorizationCodePKCE();
            $origAuthReq = $tokenManager->getByCode($body->code);
            $loginUid = $app->get("session", Session::class)->get(OidApp::SESS_KEY_LOGIN_UID);
            $userManager = $app->get("userReadManager", UserReadMangerInterface::class);
            $user = $userManager->getUserByUid($loginUid);
            $client = $app->get("clientReadManager", ClientReadManagerInterface::class)->getClientById($body->client_id);
            $scopes = explode(" ", $origAuthReq->scope);
            $flow->validate($app, $body, $origAuthReq);
        } else {
            throw new \InvalidArgumentException("Invalid flow. cannot handle grant_type without code_verifier.");
        }


        $claimManager = $app->get("claimManager", ClaimManagerInterface::class);
        $jwtBuilder = $app->get("jwtBuilder", JwtBuilderInterface::class);

        $claimManager->validateScopes($user, $client, $scopes);

        $idToken = $jwtBuilder->buildJwtToken(
            $claimManager->getIdClaims(
                $clientManager->getClientById($origAuthReq->client_id),
                $user,
                $scopes
            )
        );
        $accessToken = $jwtBuilder->buildJwtToken(
            $claimManager->getAccessClaims(
                $clientManager->getClientById($origAuthReq->client_id),
                $user,
                $scopes
            )
        );

        return [
            "access_token" => $accessToken,
            "id_token" => $idToken,
            "expires_in" => $jwtBuilder->getExpiresIn(),
            "token_type" => "Bearer"
        ];
    }

}
