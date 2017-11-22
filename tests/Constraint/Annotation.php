<?php

namespace Opstalent\CrudBundle\Tests\Constraint;

use Doctrine\Common\Annotations\Annotation as DoctrineAnnotation;
use Doctrine\Common\Annotations\DocParser;
use PHPUnit\Framework\Constraint\Constraint;

/**
 * Class AnnotationConstraint
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class Annotation extends Constraint
{
    /**
     * @param mixed $class
     * @return bool
     */
    public function matches($class): bool
    {
        $reflection = new \ReflectionClass($class);
        $docParser = $this->prepareDocParser();
        $annot = $docParser->parse($reflection->getDocComment(), 'class ' . $reflection->getName());
        foreach ($annot as $annotation) {
            if ($annotation instanceof DoctrineAnnotation\Target) {
                return true;
            }
        }

        return false;
    }

    /**
     * Returns a string representation of the constraint.
     *
     * @return string
     */
    public function toString(): string
    {
        return sprintf('is proper %s', DoctrineAnnotation::class);
    }

    /**
     * @return DocParser
     */
    protected function prepareDocParser(): DocParser
    {
        $docParser = new DocParser();
        $docParser->setIgnoreNotImportedAnnotations(true);
        $docParser->setIgnoredAnnotationNames(['Annotation' => false]);
        $docParser->setIgnoredAnnotationNamespaces([DoctrineAnnotation::class => false]);
        $docParser->addNamespace(DoctrineAnnotation::class);
        return $docParser;
    }
}
