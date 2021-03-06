<?php
/**
 * Created by PhpStorm.
 * User: Stéphane
 * Date: 28/03/2019
 * Time: 12:11
 */

namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class TaskTest extends WebTestCase
{
    private function getValidator()
    {
        $kernel = $this->createKernel();
        $kernel->boot();
        return $kernel->getContainer()->get('validator');
    }


    public function testDateNewTask()
    {
        $task = new Task();
        $this->assertContains('Europe/Berlin', $task->getCreatedAt()->getTimezone()->getName());
    }

    public function testIsDoneNewTask()
    {
        $task = new Task();
        $this->assertFalse($task->isDone());
    }

    public function testTaskValidator()
    {
        /**
         * @var ConstraintViolationListInterface $violationList
         */
        $violationList = $this->getValidator()->validate(new Task());

        $this->assertEquals(2, $violationList->count());
        // or any other like:
        $this->assertEquals('Vous devez saisir un titre.', $violationList[0]->getMessage());

        $this->assertEquals('Vous devez saisir du contenu.', $violationList[1]->getMessage());
    }
}
