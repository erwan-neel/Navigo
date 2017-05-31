<?php

/**
 * Created by PhpStorm.
 * User: Erwan
 * Date: 20/05/2017
 * Time: 16:08
 */
namespace Library;
 
require 'vendor/autoload.php';

use Library\Timer;
use PHPUnit\Framework\TestCase;

function time()
{
	return TimerTest::$now ?: \time();
}

class TimerTest extends TestCase
{
	public static $now;
	
	public function testJourActuel()
	{
		$date = "25-01-2017";
		self::$now = strtotime($date);
        $timer = new Timer();
		
		$this->assertEquals("25/01/2017", $timer->getCurrentDay());
	}

    public function testPremierEtDernierJoursDuMois()
    {
		$date = "25-01-2017";
		self::$now = strtotime($date);
        $timer = new Timer();
		
        $this->assertEquals("01/01/2017", $timer->getFirstDayOfTheCurrentMonth());
		$this->assertEquals("31/01/2017", $timer->getLastDayOfTheCurrentMonth());
		
		$fevrier = "25-02-2017";
		self::$now = strtotime($fevrier);
        $timer = new Timer();
		
		$this->assertEquals("01/02/2017", $timer->getFirstDayOfTheCurrentMonth());
		$this->assertEquals("28/02/2017", $timer->getLastDayOfTheCurrentMonth());
		
		$fevrierBisextille = "25-02-2016";
		self::$now = strtotime($fevrierBisextille);
        $timer = new Timer();
		
		$this->assertEquals("01/02/2016", $timer->getFirstDayOfTheCurrentMonth());
		$this->assertEquals("29/02/2016", $timer->getLastDayOfTheCurrentMonth());
		
		$mars = "25-03-2017";
		self::$now = strtotime($mars);
        $timer = new Timer();
		
		$this->assertEquals("01/03/2017", $timer->getFirstDayOfTheCurrentMonth());
		$this->assertEquals("31/03/2017", $timer->getLastDayOfTheCurrentMonth());
    }
}