<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 23:25
 */

namespace Library;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;

class LibreOfficeClientTest extends TestCase
{
    /** @var  $libreOfficeClient LibreOfficeClient */
    private $libreOfficeClient;
    /** @var $commandRunnerMock PHPUnit_Framework_MockObject_MockObject */
    private $commandRunnerMock;
    /** @var  $pathInfoChecker PathInfoChecker */
    private $pathInfoChecker;

    public function setUp()
    {
        $this->commandRunnerMock = $this->createMock(CommandRunner::class);
        $this->pathInfoChecker = new PathInfoChecker();
        $binary = realpath("C:\Program Files (x86)\LibreOffice 5\program\soffice.exe");
        $this->libreOfficeClient = new LibreOfficeClient($this->commandRunnerMock, $binary, $this->pathInfoChecker);
    }

    public function testItShouldThrowAnExceptionIfTheBinaryFileDoesNotExist()
    {
        $this->commandRunnerMock = $this->createMock(CommandRunner::class);
        $binary = "C:\Program Files (x86)\LibreOffice 5\soffice.exe";

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage(sprintf('Le fichier d\'exécution %s que vous avez spécifié n\'existe pas.', $binary));
        $libreOfficeClient = new LibreOfficeClient($this->commandRunnerMock, $binary, $this->pathInfoChecker);
    }

    public function testItShouldThrowAnExceptionIfTheFolderDoesNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Le dossier unCheminQuiNexistePas n\'existe pas');

        $this->libreOfficeClient
            ->convertToPdf(
                'C:\Users\ZPMR4581\Documents\Khepera\Copie de Copie de maaping_bloc_options.xlsx',
                "unCheminQuiNexistePas"
            );
    }

    public function testItShouldThrowAnExceptionIfTheSourceFileNameDoesNotExist()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Le fichier unchemin n'existe pas");

        $this->libreOfficeClient->convertToPdf('unchemin',"unCheminQuiNexistePas");
    }

    public function testItShouldThrowAnExceptionWhileConvertingFileToPdfThatHasNotTheRightExtension()
    {
        $pathInfoMock = $this->getMockBuilder(PathInfoChecker::class)
            ->setMethodsExcept(['isFileExtensionAuthorized'])
            ->getMock();
        $libreOfficeClient = new LibreOfficeClient($this->commandRunnerMock, "", $pathInfoMock);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("coucou n'est pas une extension de fichier autorisée.");

        $libreOfficeClient->convertToPdf(
            'C:\Users\ZPMR4581\Documents\Copie de Copie de maaping_bloc_options.coucou',
            'C:\Users\ZPMR4581\Documents\Khepera'
        );
    }

    public function testItShouldConvertToPdf()
    {
        $outputDir = __DIR__ . DS . 'ressources' . DS;
        $file = $outputDir .'template.docx';
        $cmd = sprintf(
            '"%s" --headless --convert-to pdf --outdir %s %s',
                "C:\Program Files (x86)\LibreOffice 5\program\soffice.exe",
                $outputDir,
                $file
        );
        $this->commandRunnerMock
            ->expects($this->once())
            ->method('execute')
            ->with($cmd);

        $this->libreOfficeClient->convertToPdf($file, $outputDir);
    }
}