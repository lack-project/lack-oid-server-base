<?php


namespace Lack\OidServer\Base\Ctrl;


use Brace\Core\BraceApp;
use Lack\OidServer\Base\Tpl\HtmlTemplate;

class SignInCtrl
{


    public function __construct(
        private HtmlTemplate $tpl
    ){}


    public function __invoke(BraceApp $app)
    {
        return $this->tpl->render($app);
    }

}
