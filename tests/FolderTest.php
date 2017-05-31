<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 29/05/2017
 * Time: 18:24
 */

namespace Library;

use Library\Folder;
use PhpOffice\PhpWord\Shared\ZipArchive;
use PHPUnit\Framework\TestCase;

class FolderTest extends TestCase
{
    use \phpmock\phpunit\PHPMock;

    public function testItShouldCreateAFolder()
    {
        $folder = new Folder();
        $this->assertInstanceOf(Folder::class, $folder);
    }

    public function testItShouldAddSeveralFiles()
    {
        $folderMock = $this->getMockBuilder(Folder::class)
            ->disableOriginalConstructor()
            ->setMethodsExcept(['addFiles'])
            ->getMock();

        $folderMock->expects($this->exactly(2))
            ->method('addFile');
        $files = [
            MODIS_TEMPLATE_PATH.DS.MODIS_OUTPUT_FILENAME,
            MODIS_TEMPLATE_PATH.DS.'fichierDeTest.pdf'
        ];
        $folderMock->addFiles($files);
    }

    public function testItShouldCreateAZipFolder()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, "file_exists");
        $time->expects($this->any())->willReturn(true);

        $folder = new Folder();
        $folder->addFile('test');
        $folder->addFile('test2');
        $folder->addFile('test3');

        $zipper = $this->createMock(\ZipArchive::class);
        $zipper->expects($this->once())->method('open');
        $zipper->expects($this->exactly(3))->method('addFile');
        $zipper->expects($this->once())->method('close');
        $folder->zip($zipper, 'toto');
    }
}