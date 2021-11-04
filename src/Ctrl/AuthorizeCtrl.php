<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Session\Session;
use Brace\Session\SessionMiddleware;
use Lack\OidServer\Base\Interface\TokenManagerInterface;
use Lack\OidServer\Base\Interface\UserReadMangerInterface;
use Lack\OidServer\Base\OidApp;
use Lack\OidServer\Base\Type\T_Q_Authorize;

class AuthorizeCtrl
{


    public function __invoke(OidApp $app, T_Q_Authorize $query, Session $session)
    {
        try {
            $client = $app->clientReadManager->getClientById($query->client_id);
            if ( ! $client->isValidRedirectTarget($query->redirect_uri))
                throw new \InvalidArgumentException("redirect_uri '{$query->redirect_uri}' is not allowed for client '{$query->client_id}'");

            if ( ! $session->has(OidApp::SESS_KEY_LOGIN_UID)) {
                if ($query->prompt === "none")
                    throw new \InvalidArgumentException("Cannot handle authentication response");
                $session->set(OidApp::SESS_KEY_LAST_AUTH_REQ, (array)$query);
                return $app->redirect("/signin");
            }

            $user = $app->get("userReadManager", UserReadMangerInterface::class)->getUserByUid(
                $session->get(OidApp::SESS_KEY_LOGIN_UID)
            );

            $code = phore_random_str(24);
            $app->get("tokenManager", TokenManagerInterface::class)->storeCode($code, $query);

            $response =  $app->redirect($query->redirect_uri, [
                "state" => $query->state,
                "code" => $code
            ]);
            return $response->withAddedHeader("X-Frame-Options", "allow-from " . $app->request->getHeaderLine("Origin"));
        } catch (\InvalidArgumentException $e) {
            return $app->redirect($query->redirect_uri, ["error" => $e->getMessage(), "error_code" => $e->getCode()]);
        }

    }
}
