<?php

namespace Opstalent\CrudBundle\Tests\Annotation;

use Opstalent\CrudBundle\Annotation\Entity;
use Opstalent\CrudBundle\Tests\AnnotationTestCase;

/**
 * Class EntityTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class EntityTest extends AnnotationTestCase
{
    /**
     * @group EntityAnnotation
     * @group Annotation
     * @test
     */
    public function isAnnotation()
    {
        $this->assertIsAnnotation(Entity::class);
    }

    /**
     * @group EntityAnnotation
     * @group Annotation
     * @test
     */
    public function entityReturnProperActionForGivenOptions()
    {
        $actions = ['addable', 'getable', 'listable', 'editable', 'deletable'];
        $entity = new Entity(['actions' => $actions]);
        $this->assertEquals($actions, $entity->getActions());
    }

    /**
     * @group EntityAnnotation
     * @group Annotation
     * @test
     */
    public function entityReturnAllCorrectActionForGivenOptions()
    {
        $actions = ['addable', 'getable', 'listable', 'editable', 'deletable', 'adorable'];
        $entity = new Entity(['actions' => $actions]);
        $this->assertNotEquals($actions, $entity->getActions());
        $properActions = ['addable', 'getable', 'listable', 'editable', 'deletable'];
        $this->assertEquals($properActions, $entity->getActions());
    }
}
