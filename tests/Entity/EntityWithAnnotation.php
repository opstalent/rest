<?php

namespace Opstalent\CrudBundle\Tests\Entity;

use Doctrine\ORM\Mapping\Column;
use Opstalent\CrudBundle\Annotation\Entity;
use Opstalent\CrudBundle\Annotation\Field;

/**
 * Class EntityWithAnnotation
 * @Entity(actions={"addable", "deletable"})
 */
class EntityWithAnnotation
{
    /**
     * @Field(actions={"addable", "editable"})
     * @Column(type="text")
     */
    protected $name;

    /**
     * @Field(actions={"addable", "editable"})
     * @Column(type="integer")
     */
    protected $number;

    /**
     * @Field(actions={"editable"})
     * @Column(type="integer")
     */
    protected $skip;
}
