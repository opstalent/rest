<?php

namespace Opstalent\CrudBundle\Tests;

use Doctrine\ORM\Mapping\Column;
use Opstalent\CrudBundle\Exception\AnnotationNotDefinedException;
use Opstalent\CrudBundle\Exception\ClassNotFoundException;
use Opstalent\CrudBundle\Exception\TypeNotAllowedException;
use Opstalent\CrudBundle\FormConfigResolver;
use Opstalent\CrudBundle\Model\Field;
use Opstalent\CrudBundle\Model\Form;
use Opstalent\CrudBundle\Tests\Entity\EntityWithAnnotation;
use Opstalent\CrudBundle\Tests\Entity\EntityWithFakeColumnType;
use Opstalent\CrudBundle\Tests\Entity\EntityWithoutColumn;
use PHPUnit\Framework\TestCase;

/**
 * Class FormConfigResolverTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class FormConfigResolverTest extends TestCase
{
    /**
     * @var FormConfigResolver
     */
    protected $service;

    /**
     * setUp FormConfigResolver
     * @before
     */
    public function setUpFormFactory()
    {
        $this->service = new FormConfigResolver();
    }

    /**
     * @group FormConfigResolver
     * @test
     */
    public function throwsClassNotExistExceptionWhenPassedClassNotExist()
    {
        $this->expectException(ClassNotFoundException::class);
        $resolved = $this->service->resolve('action', 'NotExistingClass');
    }

    /**
     * @group FormConfigResolver
     * @test
     */
    public function throwsAnnotationNotDefinedExceptionWhenClassDontHaveAnnotationForm()
    {
        $this->expectException(AnnotationNotDefinedException::class);
        $resolved = $this->service->resolve('action', \DateTime::class);
    }

    /**
     * @group FormConfigResolver
     * @test
     */
    public function getsFormModelWhenUseClassAnnotatedWithFormAnnotation()
    {
        $column = new Column(); // Needed to Use Doctrine Mapping annotations inside
        $resolver = $this->service->resolve('addable', EntityWithAnnotation::class);
        $this->assertInstanceOf(Form::class, $resolver);
    }

    /**
     * @group FormConfigResolver
     * @test
     * @depends getsFormModelWhenUseClassAnnotatedWithFormAnnotation
     */
    public function formModelContainsAllFieldsDefinedByFieldAnnotation()
    {
        $resolver = $this->service->resolve('addable', EntityWithAnnotation::class);
        foreach ($resolver->getFields() as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }

    /**
     * @group FormConfigResolver
     * @test
     */
    public function throwsAnnotationNotDefinedExceptionWhenPropertyDontHaveAnnotationColumn()
    {
        $this->expectException(AnnotationNotDefinedException::class);
        $resolver = $this->service->resolve('addable', EntityWithoutColumn::class);
        foreach ($resolver->getFields() as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }

    /**
     * @group FormConfigResolver
     * @test
     */
    public function throwTypeNotAllowedExceptionWhenEntityHaveUnsupportedColumnType()
    {
        $this->expectException(TypeNotAllowedException::class);
        $resolver = $this->service->resolve('addable', EntityWithFakeColumnType::class);
    }

}
