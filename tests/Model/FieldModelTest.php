<?php

namespace Opstalent\CrudBundle\Tests\Annotation;

use Opstalent\CrudBundle\Exception\TypeNotAllowedException;
use Opstalent\CrudBundle\Model\Field;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class FieldModelTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class FieldModelTest extends TestCase
{
    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function setsName()
    {
        $model = new Field();
        $this->assertInstanceOf(Field::class, $model->setName('user'));
        $this->assertEquals('user', $model->getName());
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeErrorWhenNameIsNotAString()
    {
        $this->expectException('TypeError');
        $model = new Field();
        $model->setName(new \DateTime());
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function setsType()
    {
        $model = new Field();
        $this->assertInstanceOf(Field::class, $model->setType(TextType::class));
        $this->assertEquals(TextType::class, $model->getType());
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function throwingErrorWhenSetUnavailableType()
    {
        $this->expectException(TypeNotAllowedException::class);
        $model = new Field();
        $model->setType('wrongType');
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeNotAllowedExceptionWhenSettingNotAllowedType()
    {
        $this->expectException(TypeNotAllowedException::class);
        $model = new Field();
        $model->setType(Field::class);
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeErrorWhenPassedNonStringAction()
    {
        $this->expectException('TypeError');
        $model = new Field();
        $model->setType(new \DateTime());
    }

    /**
     * @group FieldModel
     * @group FormFactory
     * @test
     */
    public function getFieldsReturnProperListOfFields()
    {
        $options = [1,2];
        $model = new Field();
        $this->assertInstanceOf(Field::class, $model->setOptions($options));
        $this->assertEquals($options, $model->getOptions());
    }
}
