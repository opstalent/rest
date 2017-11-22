<?php

namespace Opstalent\CrudBundle\Tests;

use Doctrine\ORM\EntityManager;
use Opstalent\CrudBundle\FormEventListener;
use Opstalent\CrudBundle\Tests\Entity\EntityWithAnnotation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Form;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Opstalent\CrudBundle\Exception\FormNotValidException;

/**
 * Class FormEventListenerTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class FormEventListenerTest extends TestCase
{

    public function getEntityManagerMock()
    {
        $entityManagerMock = $this
            ->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $entityManagerMock;
    }

    public function getFormEventMock(bool $isValid = false)
    {
        $formMock = $this
            ->getMockBuilder(Form::class)
            ->disableOriginalConstructor()
            ->getMock();

        $formMock
            ->expects($this->any())
            ->method('isValid')
            ->willReturn($isValid);

        $formEventMock = $this
            ->getMockBuilder(FormEvent::class)
            ->disableOriginalConstructor()
            ->getMock();

        $formEventMock
            ->expects($this->any())
            ->method('getForm')
            ->willReturn($formMock);

        $formEventMock
            ->expects($this->any())
            ->method('getData')
            ->willReturn(new EntityWithAnnotation());

        return $formEventMock;
    }

    /**
     * @group FormEventListener
     * @test
     */
    public function callsEMPersistOnce()
    {
        $entityManagerMock = $this->getEntityManagerMock();

        $entityManagerMock
            ->expects($persist = $this->once())
            ->method('persist');

        $formEventListener = new FormEventListener($entityManagerMock);
        $formEventListener->saveData($this->getFormEventMock(true));
        $this->assertEquals(1, $persist->getInvocationCount());
    }

    /**
     * @group FormEventListener
     * @test
     * @depends callsEMPersistOnce
     */
    public function callsEMFlushOnce()
    {
        $entityManagerMock = $this->getEntityManagerMock();

        $entityManagerMock
            ->expects($flush = $this->once())
            ->method('flush');

        $formEventListener = new FormEventListener($entityManagerMock);
        $formEventListener->saveData($this->getFormEventMock(true));
        $this->assertEquals(1, $flush->getInvocationCount());
    }

    /**
     * @group FormEventListener
     * @test
     */
    public function throwsFormNotValidWhenFormEventHasInvalidForm()
    {
        $this->expectException(FormNotValidException::class);
        $formEventListener = new FormEventListener($this->getEntityManagerMock());
        $formEventListener->saveData($this->getFormEventMock(false));
    }

    /**
     * @group FormEventListener
     * @test
     */
    public function getsPostSubmitEventFromSubscribedEvents()
    {
        $events = FormEventListener::getSubscribedEvents();
        $this->assertContains(FormEvents::POST_SUBMIT, array_keys($events));
    }

}
