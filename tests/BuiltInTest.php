<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 18:54
 */

namespace foo;

class BuiltinTest extends \PHPUnit\Framework\TestCase
{
    use \phpmock\phpunit\PHPMock;

    public function testTime()
    {
        $time = $this->getFunctionMock(__NAMESPACE__, "time");
        $time->expects($this->once())->willReturn(3);

        $this->assertEquals(3, time());
    }

    public function testExec()
    {
        $exec = $this->getFunctionMock(__NAMESPACE__, "exec");
        $exec->expects($this->once())->willReturnCallback(
            function ($command, &$output, &$return_var) {
                $this->assertEquals("foo", $command);
                $output = ["failure"];
                $return_var = 1;
            }
        );

        exec("foo", $output, $return_var);
        $this->assertEquals(["failure"], $output);
        $this->assertEquals(1, $return_var);
    }
}