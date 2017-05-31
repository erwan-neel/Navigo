<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 26/05/2017
 * Time: 12:39
 */

namespace Library;


use PhpOffice\PhpWord\TemplateProcessor;

class ApplicationFactory
{
    public function buildApp($modisTemplatePath, $modisTemplateName, $libreOfficeBinaryPath)
    {
        $timer = new Timer();
        $templateProcessor = new TemplateProcessor($modisTemplatePath . DS . $modisTemplateName);
        $cmdRunner = new CommandRunner();
        $pathInfoChecker = new PathInfoChecker();
        $pdfConverter = new LibreOfficeClient($cmdRunner, $libreOfficeBinaryPath, $pathInfoChecker);

        return new Application($timer, $templateProcessor, $pdfConverter, $pathInfoChecker);

    }
}