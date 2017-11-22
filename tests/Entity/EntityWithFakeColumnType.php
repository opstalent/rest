<?php

namespace Opstalent\CrudBundle\Tests\Entity;

use Doctrine\ORM\Mapping\Column;
use Opstalent\CrudBundle\Annotation\Entity;
use Opstalent\CrudBundle\Annotation\Field;

/**
 * Class EntityWithFakeColumnType
 * @Entity(actions={"addable", "deletable"})
 */
class EntityWithFakeColumnType
{
    /**
     * @Field(actions={"addable", "editable"})
     * @Column(type="fake")
     */
    protected $name;
}
