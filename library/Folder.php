<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 29/05/2017
 * Time: 18:23
 */

namespace Library;


class Folder
{
    private $files = [];

    public function zip(\ZipArchive $zipper, $zipPath)
    {
        $zipper->open($zipName, \ZipArchive::CREATE);

        foreach ($this->files as $file) {
            $zipper->addFile($file);
        }

        $zipper->close();
    }

    public function addFile($string)
    {
        if (!file_exists($string)) {
            throw new \Exception("Ce fichier n'existe pas");
        }

        $this->files[] = $string;
    }

    public function addFiles(array $files)
    {
        foreach ($files as $file) {
            $this->addFile($file);
        }
    }
}