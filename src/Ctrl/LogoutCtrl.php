<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Session\Session;
use Lack\OidServer\Base\OidApp;
use Lack\OidServer\Base\Type\T_Q_Logout;

class LogoutCtrl
{


    public function __invoke(OidApp $app, Session $session, T_Q_Logout $query)
    {
        $session->clear();
        $session->destroy();

        $response = $app->redirect($query->returnTo);
        return $response->withAddedHeader("Expires", 0);
    }


}
