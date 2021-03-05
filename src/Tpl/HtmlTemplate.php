<?php


namespace Lack\OidServer\Base\Tpl;


use Brace\Core\BraceApp;
use Laminas\Diactoros\Response\HtmlResponse;
use Psr\Http\Message\ResponseInterface;

class HtmlTemplate
{



    public function __construct(
        private string $fileName
    ){}

    public function setParams(array $params)
    {

    }

    protected function parseToken(string $token, array $templateData)
    {
        if (substr($token, 0, 2) === "!!")
            return isset($templateData[$token]) ? $templateData[$token] : "";
        if (strpos($token, "?") !== false) {
            $valUnset = "";
            [$token, $valIsset] = explode("?", $token);
            if (strpos($valIsset, ":") !== false) {
                [$valIsset, $valUnset] = explode(":", $valIsset);
            }
            if ( ! isset($templateData[$token]) || $templateData[$token] == null) {
                return $valUnset;
            }
            return $valIsset;
        }
        return isset($templateData[$token]) ? htmlspecialchars($templateData[$token]) : "";
    }


    protected function parseLine($tpl, $templateData, int $line)
    {
        $buf = "";
        while (true) {
            $startPos = strpos($tpl, "%%");
            if ($startPos === false) {
                $buf .= $tpl;
                break;
            }
            $buf .= substr($tpl, 0, $startPos);
            $tpl = substr($tpl, $startPos+2);

            $endPos = strpos($tpl, "%%");
            if ($endPos === false)
                throw new \InvalidArgumentException("End-token missing in template '$templateFile' line $line.");

            $token = substr($tpl, 0, $endPos);
            $buf .= $this->parseToken($token, $templateData);
            $tpl = substr($tpl, $endPos + 2);
        }
        return $buf;
    }


    protected function parseTemplate(string $templateFile, array $templateData)
    {
        if ( ! in_array(pathinfo($templateFile, PATHINFO_EXTENSION), ["html", "htm"]))
            throw new \InvalidArgumentException("Template file requires extension to be '.html' or '.htm'");
        if ( ! file_exists($templateFile))
            throw new \InvalidArgumentException("Template file '$templateFile' not existing.");
        $tpl = file($templateFile);

        for ($line=0; $line < count($tpl); $line++) {
            $tpl[$line] = $this->parseLine($tpl[$line], $templateData, $line+1);
        }
        return implode("", $tpl);
    }

    public function render(BraceApp $app, array $data) : ResponseInterface
    {
        $tpl = $this->parseTemplate($this->fileName, $data);
        $response = $app->responseFactory->createResponseWithBody($tpl);
        return $response->withHeader("Content-Type", "text/html");
    }


}
