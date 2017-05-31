<?php
/**
 * Created by PhpStorm.
 * User: ZPMR4581
 * Date: 22/05/2017
 * Time: 22:19
 */

namespace Library;

class CommandRunner
{
    public function execute($command)
    {
        exec($command);
    }
}