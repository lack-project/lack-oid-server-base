<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Session\Session;
use Brace\Session\SessionMiddleware;
use Lack\OidServer\Base\OidApp;
use Lack\OidServer\Base\Type\T_Q_Authorize;

class AuthorizeCtrl
{


    public function __invoke(OidApp $app, T_Q_Authorize $query, Session $session)
    {
        echo $session->get(OidApp::SESS_KEY_LAST_AUTH_REQ);
        if ( ! $session->has(OidApp::SESS_KEY_LOGIN_UID)) {
            $session->set(OidApp::SESS_KEY_LAST_AUTH_REQ, (array)$query);
            return $app->redirect("/signin");
        }
        $client = $app->clientReadManager->getClientById($query->client_id);
        if ( ! $client->isValidRedirectTarget($query->redirect_uri))
            throw new \InvalidArgumentException("redirect_uri '{$query->redirect_uri}' is not allowed for client '{$query->client_id}'");

        $resourceOwner = $app->resourceOwnerReadManager->getResourceOwnerById($session->get(OidApp::SESS_KEY_LOGIN_UID));

        return $app->redirect($query->redirect_uri, [
            "token" => "some token"
        ]);

    }
}
