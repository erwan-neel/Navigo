<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 18:58
 */

namespace Library;

use Library\Application;
use Library\LibreOfficeClient;
use Library\PathInfoChecker;
use Library\Timer;
use PhpOffice\PhpWord\TemplateProcessor;
use PHPUnit\Framework\TestCase;

require 'vendor/autoload.php';
require 'configs.php';

class ApplicationTest extends TestCase
{
    use \phpmock\phpunit\PHPMock;
    private $application;

    public function testSaveWordDocumentShouldEmitAnExceptionWhenFileExtensionIsNotDocx()
    {
        $timerMock = $this->createMock(Timer::class);
        $templateProcessorMock = $this->createMock(TemplateProcessor::class);
        $pdfConverterMock = $this->createMock(LibreOfficeClient::class);
        $pathInfoChecker = new PathInfoChecker();

        $app = new Application($timerMock, $templateProcessorMock, $pdfConverterMock, $pathInfoChecker);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("doc n'est pas une extension de fichier autorisée.");

        $app->saveWordDoc("", "test.doc");
    }

    public function testSaveWordDocument()
    {
        $timerMock = $this->createMock(Timer::class);
        $timerMock->expects($this->exactly(1))
            ->method('getFirstDayOfTheCurrentMonth')
            ->willReturn('01/05/2017');
        $timerMock->expects($this->once())
            ->method('getLastDayOfTheCurrentMonth')
            ->willReturn('31/05/2017');
        $timerMock->expects($this->once())
            ->method('getCurrentDay')
            ->willReturn('22/05/2017');

        $templateProcessorMock = $this->createMock(TemplateProcessor::class);
        $templateProcessorMock->expects($this->exactly(3))
            ->method('setValue')
            ->withConsecutive(
                [
                    $this->equalTo('dateDebut'),
                    $this->equalTo('01/05/2017')
                ],
                [
                    $this->equalTo('dateFin'),
                    $this->equalTo('31/05/2017')
                ],
                [
                    $this->equalTo('dateSignature'),
                    $this->equalTo('22/05/2017')
                ]
            );
        $templateProcessorMock->expects($this->once())
            ->method('saveAs')
            ->with(MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME);

        $pdfConverterMock = $this->createMock(LibreOfficeClient::class);
        $pathInfoChecker = new PathInfoChecker();

        $this->application = new Application($timerMock, $templateProcessorMock, $pdfConverterMock, $pathInfoChecker);
        $this->application->saveWordDoc(MODIS_TEMPLATE_PATH, MODIS_OUTPUT_FILENAME);
    }

    public function testItShouldTransformDocWordToPdf()
    {
        $timerMock = $this->createMock(Timer::class);
        $templateProcessorMock = $this->createMock(TemplateProcessor::class);
        $pdfConverterMock = $this->createMock(LibreOfficeClient::class);
        $pdfConverterMock
            ->expects($this->once())
            ->method('convertToPdf')
            ->with(
                MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME,
                MODIS_TEMPLATE_PATH
            );

        $pathInfoChecker = new PathInfoChecker();

        $this->application = new Application($timerMock, $templateProcessorMock, $pdfConverterMock, $pathInfoChecker);
        $this->application->transformDocToPdf(
            MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME,
            MODIS_TEMPLATE_PATH
        );
    }

    public function testRunMethodCallsEveryone()
    {
        $mock = $this->getMockBuilder(Application::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['run'])
            ->getMock();

        $mock->expects($this->once())
            ->method("saveWordDoc")
            ->with(
                MODIS_TEMPLATE_PATH,
                MODIS_OUTPUT_FILENAME
            );

        $mock->expects($this->once())
            ->method('transformDocToPdf')
            ->with(
                MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME,
                MODIS_TEMPLATE_PATH
            );

        $mock->run(MODIS_TEMPLATE_PATH, MODIS_OUTPUT_FILENAME);
    }
}