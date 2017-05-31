<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 19:12
 */

namespace Library;

use PhpOffice\PhpWord\TemplateProcessor;

class Application
{
    private $templateProcessor;
    private $timer;
    private $pdfConverter;
    private $pathInfoChecker;

    public function __construct(
        Timer $timer,
        TemplateProcessor $templateProcessor,
        DocToPDFConverter $pdfConverter,
        PathInfoChecker $pathInfoChecker
    )
    {
        $this->timer = $timer;
        $this->templateProcessor = $templateProcessor;
        $this->pdfConverter = $pdfConverter;
        $this->pathInfoChecker = $pathInfoChecker;
    }

    public function run($modisTemplatePath, $modisOutputFileName)
    {
        $this->saveWordDoc($modisTemplatePath, $modisOutputFileName);
        $this->transformDocToPdf($modisTemplatePath."\\".$modisOutputFileName, $modisTemplatePath);
    }

    public function saveWordDoc($outputDir, $fileName)
    {
        $this->pathInfoChecker->isFileExtensionAuthorized($fileName, ['docx']);

        // prepare the doc
        $this->templateProcessor->setValue('dateDebut', $this->timer->getFirstDayOfTheCurrentMonth());
        $this->templateProcessor->setValue('dateFin', $this->timer->getLastDayOfTheCurrentMonth());
        $this->templateProcessor->setValue('dateSignature', $this->timer->getCurrentDay());

        // save the doc
        $this->templateProcessor->saveAs($outputDir.'\\'.$fileName);
    }

    public function prepareDocTemplate(array $vars, $fileName)
    {
        $this->pathInfoChecker->isFileExtensionAuthorized($fileName, ['docx']);

        foreach ($vars as $var => $value) {
            $this->templateProcessor->setValue($var, $value);
        }
    }

    public function saveDocTemplate($fileNamePath)
    {
        $this->pathInfoChecker->existFolder(pathinfo($fileNamePath, PATHINFO_DIRNAME));
        $this->templateProcessor->saveAs($fileNamePath);
    }

    public function transformDocToPdf($sourceFileName, $outDirPath)
    {
        $this->pdfConverter->convertToPdf($sourceFileName, $outDirPath);
    }
}