<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 30/05/2017
 * Time: 08:15
 */

namespace Library;


use PhpOffice\PhpWord\TemplateProcessor;

class TemplateManager
{
    private $processor;

    public function __construct(TemplateProcessor $processor, array $vars)
    {
        $this->processor = $processor;

        foreach ($vars as $key => $var) {
            $processor->setValue($key, $var);
        }
    }

    public function saveAs($filePath)
    {
        $this->processor->saveAs($filePath);
    }
}