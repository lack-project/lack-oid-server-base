<?php

namespace Lack\OidServer\Base\Flows;

use Brace\Core\BraceApp;
use Lack\OidServer\Base\Type\T_Q_Authorize;
use Lack\OidServer\Base\Type\T_Q_Token;

interface GrantTypeFlowInterface
{
    public function process(BraceApp $app, T_Q_Token $tokenReq, T_Q_Authorize $authReq);
}
