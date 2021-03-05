<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Core\BraceApp;
use Brace\Session\Session;
use Lack\OidServer\Base\OidApp;
use Lack\OidServer\Base\Tpl\HtmlTemplate;
use Phore\Core\Exception\NotFoundException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ServerRequestInterface;

class SignInCtrl
{


    public function __construct(
        private HtmlTemplate $tpl
    ){}


    public function __invoke(OidApp $app, ServerRequestInterface $request, Session $session)
    {

        if ($request->getMethod() === "GET") {
            return $this->tpl->render($app, []);
        }

        // Wait some time so rate limit can apply to password brute force attacks
        usleep(mt_rand(1300, 2255) * 1000);

        $uidOrEmail = $request->getParsedBody()["user"] ?? "";
        $password = $request->getParsedBody()["passwd"] ?? "";

        if ($uidOrEmail === "")
            return $app->redirect("", ["error" => "No user sprecified"]);
        if ($password === "")
            return $app->redirect("", ["error"=>"please specify password"]);

        try {
            $resourceOwner = $app->resourceOwnerReadManager->findResourceOwner($uidOrEmail);
        } catch (NotFoundException $e) {
            $app->redirect("", ["error" => "Invalid user/password"]);
        }
        if ( ! $resourceOwner->isValidSecret($password)) {
            return $app->redirect("", ["error"=>"Invalid password"]);
        }

        $session->set(OidApp::SESS_KEY_LOGIN_UID, $resourceOwner->getUid());
        $authRequest = $session->get(OidApp::SESS_KEY_LAST_AUTH_REQ);
        $session->remove(OidApp::SESS_KEY_LAST_AUTH_REQ);

        if ($authRequest === null) {
            return $app->redirect($app->tenantConfig->getDefaultLocationUri());
        }

        return $app->redirect("/authorize", $authRequest);
    }

}
