<?php

namespace Opstalent\CrudBundle\Tests\Entity;

use Opstalent\CrudBundle\Annotation\Entity;
use Opstalent\CrudBundle\Annotation\Field;

/**
 * Class EntityWithoutColumn
 * @Entity(actions={"addable", "deletable"})
 */
class EntityWithoutColumn
{
    /**
     * @Field(actions={"addable", "editable"})
     */
    protected $name;
}
