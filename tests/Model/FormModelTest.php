<?php

namespace Opstalent\CrudBundle\Tests\Annotation;

use Opstalent\CrudBundle\Exception\ActionUnavailableException;
use Opstalent\CrudBundle\Model\Field;
use Opstalent\CrudBundle\Model\Form;
use PHPUnit\Framework\TestCase;

/**
 * Class FormModelTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class FormModelTest extends TestCase
{
    protected $form;
    protected $field;

    /**
     * @before
     */
    public function setUpForm()
    {
        $this->form = new Form();
    }

    /**
     * @before
     */
    public function setUpField()
    {
        $this->field = new Field();
        $this->field->setName('one');
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function setsName()
    {
        $this->assertInstanceOf(Form::class, $this->form->setName('user'));
        $this->assertEquals('user', $this->form->getName());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeErrorWhenNameIsNotAString()
    {
        $this->expectException('TypeError');
        $this->form->setName(new \DateTime());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function setsAction()
    {
        $this->assertInstanceOf(Form::class, $this->form->setAction('addable'));
        $this->assertEquals('addable', $this->form->getAction());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function throwingErrorWhenSetUnavailableAction()
    {
        $this->expectException(ActionUnavailableException::class);
        $this->assertInstanceOf(Form::class, $this->form->setAction('wrongable'));
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeErrorWhenPassedNonStringAction()
    {
        $this->expectException('TypeError');
        $this->form->setAction(new \DateTime());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function getFieldsReturnsProperListOfFields()
    {
        $field2 = clone $this->field;
        $field2->setName("two");
        $fields = ["one" => $this->field, "two" => $field2];
        $this->assertInstanceOf(Form::class, $this->form->setFields($fields));
        $this->assertEquals($fields, $this->form->getFields());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function addField()
    {
        $this->field->setName('user');
        $this->assertInstanceOf(Form::class, $this->form->addField($this->field));
        $this->assertEquals(1, count($this->form->getFields()));
        $this->assertEquals(['user' => $this->field], $this->form->getFields());
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     */
    public function throwingTypeErrorWhenPassingNotFieldToAddField()
    {
        $this->expectException('TypeError');
        $this->assertInstanceOf(Form::class, $this->form->addField(new \DateTime));
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     * @depends addField
     */
    public function removeField()
    {
        $this->field->setName('user');
        $this->form->addField($this->field);
        $this->form->removeField('user');
        $this->assertEquals(0, count($this->form->getFields()));
    }

    /**
     * @group FormModel
     * @group FormFactory
     * @test
     * @depends addField
     */
    public function removeUnexistingField()
    {
        $this->field->setName('user');
        $this->form->addField($this->field);
        $this->form->removeField('unexistingField');
        $this->assertEquals(1, count($this->form->getFields()));
    }
}
