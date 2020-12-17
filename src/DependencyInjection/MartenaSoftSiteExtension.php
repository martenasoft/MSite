<?php

namespace MartenaSoft\Site\DependencyInjection;

use Doctrine\ORM\EntityManagerInterface;
use MartenaSoft\Media\MartenaSoftMediaBundle;
use MartenaSoft\Site\MartenaSoftSiteBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class MartenaSoftSiteExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {

      /*  $container->prependExtensionConfig(MartenaSoftMediaBundle::class, [
            'images_path' => [
                'articles' => [
                    'dir' => 'articles',
                    'small' => [
                        'width' => 120,
                        'height' => 120,
                        'path' => 'small'
                    ]
                ]
            ]
        ]);*/
        // get all bundles
      /*  $bundles = $container->getParameter('kernel.bundles');

        // determine if AcmeGoodbyeBundle is registered
        if (!isset($bundles['AcmeGoodbyeBundle'])) {
            // disable AcmeGoodbyeBundle in bundles
            $config = ['use_acme_goodbye' => false];
            foreach ($container->getExtensions() as $name => $extension) {
                switch ($name) {
                    case 'acme_something':
                    case 'acme_other':
                        // set use_acme_goodbye to false in the config of
                        // acme_something and acme_other
                        //
                        // note that if the user manually configured
                        // use_acme_goodbye to true in config/services.yaml
                        // then the setting would in the end be true and not false
                        $container->prependExtensionConfig($name, $config);
                        break;
                }
            }
        }*/
    }


    public function load(array $configs, ContainerBuilder $container): void
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