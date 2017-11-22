<?php

namespace Opstalent\RestBundle\Tests\Annotation;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Opstalent\RestBundle\DependencyInjection\OpstalentRestExtension;

/**
 * Class OpstalentRestExtensionTest
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\RestBundle
 */
class OpstalentRestExtensionTest extends AbstractExtensionTestCase
{
    /**
     * @return array
     */
    protected function getContainerExtensions()
    {
        return [
            new OpstalentRestExtension(),
        ];
    }

    /**
     * @group OpstalentRestExtension
     * @group FormFactory
     * @test
     */
    public function loadsFormFactoryService()
    {
        $this->load();
        $this->assertContainerBuilderHasService(
            'opstalent.form_factory.service',
            'Opstalent\RestBundle\FormFactory'
        );
    }
}
