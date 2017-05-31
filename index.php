<?php
/**
 * Created by PhpStorm.
 * User: Erwan
 * Date: 20/05/2017
 * Time: 14:12
 */

require_once 'vendor/autoload.php';
require_once 'configs.php';

use Library\Application;
use Library\ApplicationFactory;
use Library\CommandRunner;
use Library\Folder;
use Library\LibreOfficeClient;
use Library\PathInfoChecker;
use Library\TemplateManager;
use Library\Timer;
use PhpOffice\PhpWord\TemplateProcessor;

// 1) Create the template and process the template
$modisTemplate = new TemplateProcessor(MODIS_TEMPLATE_PATH.DS.MODIS_TEMPLATE_NAME);
$timer = new Timer();
$vars = [
    'dateDebut' => $timer->getFirstDayOfTheCurrentMonth(),
    'dateFin' => $timer->getLastDayOfTheCurrentMonth(),
    'dateSignature' => $timer->getCurrentDay()
];
$modisTemplateManager = new TemplateManager($modisTemplate, $vars);
$modisTemplateManager->saveAs(MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME);

// 2) Create the folder containing all files to send and zip process
$zipper = new ZipArchive();
$folder = new Folder();
$files = [
    MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME,
    MODIS_TEMPLATE_PATH.DS.'fichierDeTest.pdf'
];
$folder->addFiles($files);
$folder->zip($zipper, MODIS_TEMPLATE_PATH.DS.'Remboursement_Navigo');

$appFactory = new ApplicationFactory();
$app = $appFactory->buildApp(
    MODIS_TEMPLATE_PATH,
    MODIS_TEMPLATE_NAME,
    LIBRE_OFFICE_BINARY_PATH
);
$app->run(
    MODIS_TEMPLATE_PATH,
    MODIS_OUTPUT_FILENAME
);

echo 'Fichier sauvegarde';

