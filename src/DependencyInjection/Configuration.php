<?php

namespace KnpU\LoremIpsumBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * @inheritDoc
     */
    public function getConfigTreeBuilder()
      {
          // TODO: Implement getConfigTreeBuilder() method.
          $treeBuilder = new TreeBuilder();
          $rootNode = $treeBuilder->root('knpu_lorem_ipsum');
          $rootNode->children()
              ->booleanNode('unicorns_are_real')->defaultTrue()->info('Whether you believe in unicorns')->end()
              ->integerNode('min_sunshine')->defaultValue(3)->info('How much you like sunshine')->end()
              ->end();
          return $treeBuilder;

    }
}