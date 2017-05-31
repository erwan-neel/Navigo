<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 30/05/2017
 * Time: 08:13
 */

namespace Library;


use PhpOffice\PhpWord\TemplateProcessor;
use PHPUnit\Framework\TestCase;

class TemplateManagerTest extends TestCase
{
    public function testItShouldCreateATemplateManager()
    {
        $modisTemplateMock = $this->createMock(TemplateProcessor::class);
        $modisTemplateMock->expects($this->exactly(3))->method('setValue');

        $vars = [
            'var1' => 'value1',
            'var2' => 'value2',
            'var3' => 'value3'
        ];
        new TemplateManager($modisTemplateMock, $vars);
    }

    public function testItShouldSaveTheTemplate()
    {
        $modisTemplateMock = $this->createMock(TemplateProcessor::class);
        $modisTemplateMock->expects($this->exactly(3))->method('setValue');
        $modisTemplateMock->expects($this->exactly(1))
            ->method('saveAs')
            ->with('toto');

        $vars = [
            'var1' => 'value1',
            'var2' => 'value2',
            'var3' => 'value3'
        ];
        $templateManager = new TemplateManager($modisTemplateMock, $vars);
        $templateManager->saveAs('toto');
    }
}