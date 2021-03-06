<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Session\Session;
use Lack\OidServer\Base\OidApp;

class SignOutCtrl
{


    public function __invoke(OidApp $app, Session $session)
    {
        $session->clear();
        return $app->redirect("/signin");
    }


}
