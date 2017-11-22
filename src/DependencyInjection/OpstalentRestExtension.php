<?php

namespace Opstalent\RestBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class OpstalentRestExtension
 * @author Szymon Kunowski <szymon.kunowski@gmail.com>
 * @package Opstalent\RestBundle
 */
class OpstalentRestExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $ymlLoader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../../Resource/config')
        );
        $ymlLoader->load('services.yml');
    }
}
