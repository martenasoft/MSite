<?php

namespace MartenaSoft\Site\DependencyInjection;

use MartenaSoft\Common\Service\ConfigService\CommonConfigService;
use MartenaSoft\Site\MartenaSoftSiteBundle;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder(MartenaSoftSiteBundle::getConfigName());

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('some_value')->defaultValue('some value 11')->end()
            ->scalarNode(CommonConfigService::ENTITY_CONFIG_NAME)->end()
            ->end();

        return $treeBuilder;
    }
}
