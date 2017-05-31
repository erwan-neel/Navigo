<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 26/05/2017
 * Time: 12:41
 */

namespace Library;


use PHPUnit\Framework\TestCase;

class ApplicationFactoryTest extends TestCase
{
    public function testItShouldCreateAnApp()
    {
        $nameFactory = new ApplicationFactory();
        $this->assertInstanceOf(Application::class, $nameFactory->buildApp(
            MODIS_TEMPLATE_PATH,
            MODIS_TEMPLATE_NAME,
            LIBRE_OFFICE_BINARY_PATH
            )
        );
    }
}