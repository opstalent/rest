<?php

namespace Opstalent\CrudBundle\Tests;

use Opstalent\CrudBundle\Tests\Constraint\Annotation;
use PHPUnit\Framework\TestCase;

/**
 * Class AnnotationTestCase
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle\Tests
 */
class AnnotationTestCase extends TestCase
{
    /**
     * @param string $class
     * @param string $message
     */
    public static function assertIsAnnotation(string $class, $message = "")
    {
        self::assertThat($class, new Annotation(), $message);
    }
}
