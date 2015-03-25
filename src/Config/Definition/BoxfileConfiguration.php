<?php

namespace derhasi\boxfile\Config\Definition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class BoxfileConfiguration implements ConfigurationInterface {

    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('boxfile');

        $children = $rootNode->children();

        $children->scalarNode('version')->end();
        $children->arrayNode('shared_folders')->prototype('scalar')->end();
        $children->arrayNode('env_specific_files')
          ->useAttributeAsKey('target')
          ->prototype('array')
            ->useAttributeAsKey('environment')->prototype('scalar')->end()
          ->end()
        ;
        $children->end();

        return $treeBuilder;
    }
}
