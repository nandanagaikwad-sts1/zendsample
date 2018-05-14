<?php
/**
 * Created by PhpStorm.
 * User: nandana.gaikwad
 * Date: 3/20/2017
 * Time: 3:17 PM
 */

require_once(__DIR__ . '/../../../../vendor/autoload.php');

use Mockery as m;

class JustToCheckMockeryTest extends \PHPUnit_Framework_TestCase {


    protected function tearDown() {
        \Mockery::close();
    }


    function testMockeryWorks() {
        $mock = m::mock('AClassToBeMocked');
        $mock->shouldReceive('someMethod')->once();

        $workerObject = new AClassToWorkWith;
        $workerObject->doSomethingWit($mock);
    }
}

class AClassToBeMocked {}

class AClassToWorkWith {

    function doSomethingWit($anotherClass) {
       // return $anotherClass->someMethod();
        return "here is to go";
    }

}


