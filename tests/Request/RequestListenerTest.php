<?php

namespace Opstalent\CrudBundle\Tests;

use Opstalent\CrudBundle\Request\CrudRequestInterface;
use Opstalent\CrudBundle\Request\RequestListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Opstalent\CrudBundle\FormConfigResolver;
use Opstalent\CrudBundle\FormFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ParameterBag;
use Opstalent\CrudBundle\Tests\Entity\EntityWithAnnotation;

/**
 * Class RequestListenerTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class RequestListenerTest extends TestCase
{
    /**
     * @param bool $master
     * @param Request $request
     * @return GetResponseEvent
     */
    public function getResponseEventMock(bool $master = false, Request $request)
    {
        $mock = $this
            ->getMockBuilder(GetResponseEvent::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mock->method('isMasterRequest')->willReturn($master);
        $mock->method('getRequest')->willReturn($request);
        return $mock;
    }

    /**
     * @return FormConfigResolver
     */
    public function getFormConfigResolverMock()
    {
        return $this
            ->getMockBuilder(FormConfigResolver::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return FormFactory
     */
    public function getFormFactoryMock()
    {
        return $this
            ->getMockBuilder(FormFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return Request
     */
    public function getRequestMock()
    {
        $requestMock =  $this
            ->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        $requestMock->query = new ParameterBag();
        $requestMock->request = new ParameterBag();
        $requestMock->attributes = new ParameterBag();
        $requestMock->cookies = new ParameterBag();
        $requestMock->files = new ParameterBag();
        $requestMock->server = new ParameterBag();
        $requestMock->headers = new ParameterBag();

        return $requestMock;
    }

    /**
     * @return AbstractCrudRequest
     */
    public function getAbstractCrudRequestMock()
    {
        $crudHandlingInterfaceMock = $this
            ->getMockBuilder(CrudRequestInterface::class)
            ->getMock();
        $crudHandlingInterfaceMock
            ->method('getAction')
            ->willReturn('addable');

        $crudHandlingInterfaceMock
            ->method('getClassName')
            ->willReturn(EntityWithAnnotation::class);

        $attributesMock = $this
            ->getMockBuilder(ParameterBag::class)
            ->disableOriginalConstructor()
            ->getMock();
        $attributesMock
            ->method('get')
            ->willReturn($crudHandlingInterfaceMock);

        $requestMock = $this->getRequestMock();
        $requestMock->attributes = $attributesMock;
        return $requestMock;
    }

    /**
     * @group RequestListener
     * @test
     */
    public function handlesFormReturnsFormInterface()
    {
        $listener = new RequestListener($this->getFormConfigResolverMock(), $this->getFormFactoryMock());
        $result = $listener->handleForm($this->getResponseEventMock(true, $this->getAbstractCrudRequestMock()));
        $this->assertInstanceOf(FormInterface::class, $result);
    }

    /**
     * @group RequestListener
     * @test
     */
    public function getsKernelEventRequestFromSubscribedEvents()
    {
        $events = RequestListener::getSubscribedEvents();
        $this->assertContains(KernelEvents::REQUEST, array_keys($events));
    }

    /**
     * @group RequestListener
     * @test
     */
    public function handlesFormReturnsVoidForChildrenRequest()
    {
        $listener = new RequestListener($this->getFormConfigResolverMock(), $this->getFormFactoryMock());
        $result = $listener->handleForm($this->getResponseEventMock(false, $this->getAbstractCrudRequestMock()));
        $this->assertNull($result);
    }

    /**
     * @group RequestListener
     * @test
     */
    public function handlesFormReturnsVoidForRequestWithoutCrudInterface()
    {
        $listener = new RequestListener($this->getFormConfigResolverMock(), $this->getFormFactoryMock());
        $result = $listener->handleForm($this->getResponseEventMock(true, $this->getRequestMock()));
        $this->assertNull($result);
    }

}
