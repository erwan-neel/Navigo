<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 22:16
 */

namespace Library;

use Library\CommandRunner;
use PHPUnit\Framework\TestCase;

class CommandRunnerTest extends TestCase
{
    use \phpmock\phpunit\PHPMock;

    public function testExec()
    {
        $exec = $this->getFunctionMock(__NAMESPACE__, "exec");
        $exec->expects($this->once())->with("une commande de test");

        $commandRunner = new CommandRunner();
        $cmd = "une commande de test";
        $commandRunner->execute($cmd);
    }
}