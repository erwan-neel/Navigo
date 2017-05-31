<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 23:21
 */

namespace Library;

interface DocToPDFConverter
{
    public function convertToPdf($outDirPath, $fileName);
}