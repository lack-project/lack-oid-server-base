<?php


namespace Lack\OidServer\Base\Tpl;


use Brace\Core\BraceApp;
use Laminas\Diactoros\Response\HtmlResponse;

class HtmlTemplate
{



    public function __construct(
        private string $fileName
    ){}

    public function setParams(array $params)
    {

    }

    public function render(BraceApp $app) : HtmlResponse
    {
        return $app->responseFactory->createResponseWithBody(
            file_get_contents($this->fileName)
        );
    }


}
