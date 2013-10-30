<?php
namespace Dlin\Bundle\SaasuBundle\Test\Dlin\Bundle\SaasuBundle;

use Dlin\Bundle\SaasuBundle\Service\SaasuService;

class SaasuServiceTest extends \PHPUnit_Framework_TestCase{



    public function testSchedule()
    {
        $service = new SaasuService('key','file');
        $service->schedule('xxxx', "data");

        $this->assertEquals(0, count($service->getSchedule()));

        $service->schedule('saveEntity', "1");
        $service->schedule('saveEntity', "3");

        $schedule  =$service->getSchedule();
        $this->assertEquals(1, count($schedule));
        $this->assertEquals(2, count($schedule['saveEntity']));


        $service->schedule('deleteEntity', "3");
        $schedule  =$service->getSchedule();
        $this->assertEquals(2, count($schedule));


    }

}
