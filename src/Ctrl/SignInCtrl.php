<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Core\BraceApp;
use Brace\Session\Session;
use Lack\OidServer\Base\Interface\UserReadMangerInterface;
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
            return $this->tpl->render($app, [
                "msg" => $request->getQueryParams()["msg"] ?? null,
                "ok_msg" => $request->getQueryParams()["ok_msg"] ?? null,
                "user" => $request->getQueryParams()["user"] ?? "",
            ]);
        }

        // Wait some time so rate limit can apply to password brute force attacks
        usleep(mt_rand(1300, 2255) * 100);

        $uidOrEmail = $request->getParsedBody()["user"] ?? "";
        $password = $request->getParsedBody()["passwd"] ?? "";

        if ($uidOrEmail === "")
            return $app->redirect("", ["msg" => "No user sprecified"]);
        if ($password === "")
            return $app->redirect("", ["msg"=>"please specify password", "user" => $uidOrEmail]);

        try {
            $user = $app->get("userReadManager", UserReadMangerInterface::class)->findUser($uidOrEmail);
            if ( ! $user->isValidSecret($password)) {
                return $app->redirect("", ["msg"=>"Invalid password", "user" => $uidOrEmail]);
            }
            $session->set(OidApp::SESS_KEY_LOGIN_UID, $user->getUid());
            $authRequest = $session->get(OidApp::SESS_KEY_LAST_AUTH_REQ);

            $session->remove(OidApp::SESS_KEY_LAST_AUTH_REQ);
            return $app->redirect("/authorize", $authRequest);
        } catch (NotFoundException $e) {
            return $app->redirect("", ["msg" => "Invalid user/password", "user" => $uidOrEmail]);
        }



    }

}
