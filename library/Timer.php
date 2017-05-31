<?php
/**
 * Created by PhpStorm.
 * User: Erwan
 * Date: 20/05/2017
 * Time: 16:02
 */

namespace Library;

use Zend\Validator\Date;

class Timer
{
    public function getFirstDayOfTheCurrentMonth()
    {
        return date("01/m/Y", time());
    }
	
	public function getLastDayOfTheCurrentMonth()
	{
		return date("t/m/Y", time());
	}
	
	public function getCurrentDay()
	{
		return date("d/m/Y", time());
	}
}