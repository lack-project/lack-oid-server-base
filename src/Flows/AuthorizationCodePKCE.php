<?php

namespace Lack\OidServer\Base\Flows;

use Brace\Core\BraceApp;
use Lack\OidServer\Base\Type\T_Q_Authorize;
use Lack\OidServer\Base\Type\T_Q_Token;

class AuthorizationCodePKCE implements GrantTypeFlowInterface
{

    const CODE_VERIFYIER_TYPES = [
        "S256" => "SHA256"
    ];

    private function isValidVerifier(string $challange, string $challangeType, string $verifyer) : bool
    {
        if ( ! isset (self::CODE_VERIFYIER_TYPES[$challangeType]))
            throw new \InvalidArgumentException("Invalid challange type '$challangeType'");

        return hash(self::CODE_VERIFYIER_TYPES[$challangeType], $verifyer) === $challange;
    }


    public function validate(BraceApp $app, T_Q_Token $tokenReq, T_Q_Authorize $origAuthReq)
    {
        $tokenReq->code_verifier ?? throw new \InvalidArgumentException("Required parameter 'code_verifier' missing");
        $tokenReq->code ?? throw new \InvalidArgumentException("Required parameter 'code' missing");
        $tokenReq->redirect_uri ?? throw new \InvalidArgumentException("Required parameter 'redirect_uri' missing");


        if ($tokenReq->redirect_uri !== $origAuthReq->redirect_uri)
            throw new \InvalidArgumentException("Security exception: Parameter redirect_uri '{$tokenReq->redirect_uri}' must exactly match original redirect_uri '$origAuthReq->redirect_uri'");

        if ( ! $this->isValidVerifier($origAuthReq->code_challenge, $origAuthReq->code_challenge_method, $tokenReq->code_verifier))
            throw new \InvalidArgumentException("Security exception: Code verifier in code_verifier does not match code_challange");

    }
}
