<?php

namespace Opstalent\CrudBundle\Tests\Annotation;

use Opstalent\CrudBundle\Annotation\Field;
use Opstalent\CrudBundle\Tests\AnnotationTestCase;
use Opstalent\CrudBundle\Tests\Resources\Entity\CategoryEntityMock;

/**
 * Class FieldTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class FieldTest extends AnnotationTestCase
{
    /**
     * @group FieldAnnotation
     * @group Annotation
     * @test
     */
    public function isAnnotation()
    {
        $this->assertIsAnnotation(Field::class);
    }

    /**
     * @group FieldAnnotation
     * @group Annotation
     * @test
     */
    public function fieldReturnProperActionForGivenOptions()
    {
        $actions = ['addable', 'getable', 'listable', 'editable'];
        $field = new Field(['actions' => $actions]);
        $this->assertEquals($actions, $field->getActions());
    }

    /**
     * @group FieldAnnotation
     * @group Annotation
     * @test
     */
    public function fieldReturnAllCorrectActionForGivenOptions()
    {
        $actions = ['addable', 'getable', 'listable', 'editable', 'adorable'];
        $field = new Field(['actions' => $actions]);
        $this->assertNotEquals($actions, $field->getActions());
        $properActions = ['addable', 'getable', 'listable', 'editable'];
        $this->assertEquals($properActions, $field->getActions());
    }
}
