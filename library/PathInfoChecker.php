<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 25/05/2017
 * Time: 15:16
 */

namespace Library;


class PathInfoChecker
{
    public function existFile($file)
    {
        if (!file_exists($file)) {
            throw new \Exception(sprintf("Le fichier %s n'existe pas", $file));
        }
    }

    public function existFolder($folder)
    {
        if (!file_exists($folder)) {
            throw new \Exception(sprintf("Le dossier %s n'existe pas", $folder));
        }
    }

    public function existBinary($binary)
    {
        $realBinary = realpath($binary);
        if (!$realBinary) {
            throw new \Exception(sprintf('Le fichier d\'exécution %s que vous avez spécifié n\'existe pas.', $binary));
        }
    }

    public function isFileExtensionAuthorized($file, array $extensions)
    {
        $extension = pathinfo($file, PATHINFO_EXTENSION);

        if (!in_array($extension, $extensions)) {
            throw new \Exception(sprintf('%s n\'est pas une extension de fichier autorisée.', $extension));
        }
    }
}