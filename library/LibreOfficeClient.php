<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 23:23
 */

namespace Library;


class LibreOfficeClient implements DocToPDFConverter
{
    private $commandRunner;
    private $binary;
    private $sofficeCommand;
    private $pathInfoChecker;

    public function __construct(CommandRunner $commandRunner, $binary, PathInfoChecker $pathInfoChecker)
    {
        $this->commandRunner = $commandRunner;
        $this->pathInfoChecker = $pathInfoChecker;
        $this->pathInfoChecker->existBinary($binary);
        $this->sofficeCommand = sprintf('"%s" --headless --convert-to pdf --outdir ', $binary);
    }

    public function convertToPdf($sourceFilePath, $outDirPath)
    {
        $this->pathInfoChecker->existFile($sourceFilePath);
        $this->pathInfoChecker->existFolder($outDirPath);
        $this->pathInfoChecker->isFileExtensionAuthorized($sourceFilePath, ['doc', 'docx']);

        $this->sofficeCommand .= $outDirPath.' '.$sourceFilePath;
        $this->commandRunner->execute($this->sofficeCommand);
    }
}