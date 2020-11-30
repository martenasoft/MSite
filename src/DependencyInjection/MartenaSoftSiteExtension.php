<?php

namespace MartenaSoft\Site\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Site\MartenaSoftSiteBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MartenaSoftSiteExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter(MartenaSoftSiteBundle::getConfigName(), $config);

        $loader = new YamlFileLoader(
            $container,
            new FileLocator(dirname(__DIR__).'/Resources/config')
        );
        $loader->load('services.yaml');
    }
}