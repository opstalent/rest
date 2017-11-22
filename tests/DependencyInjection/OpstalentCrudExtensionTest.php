<?php

namespace Opstalent\CrudBundle\Tests\Annotation;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Opstalent\CrudBundle\DependencyInjection\OpstalentCrudExtension;

/**
 * Class OpstalentCrudExtensionTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\CrudBundle
 */
class OpstalentCrudExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    protected function getContainerExtensions()
    {
        return [
            new OpstalentCrudExtension(),
        ];
    }

    /**
     * @group OpstalentCrudExtension
     * @group FormFactory
     * @test
     */
    public function loadsFormFactoryService()
    {
        $this->load();
        $this->assertContainerBuilderHasService(
            'opstalent.form_factory.service',
            'Opstalent\CrudBundle\FormFactory'
        );
    }
}
