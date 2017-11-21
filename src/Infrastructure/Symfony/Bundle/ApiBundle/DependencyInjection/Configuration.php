<?php


namespace LetShout\Infrastructure\Symfony\Bundle\ApiBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('let_shout_api');

        $rootNode
            ->children()
                ->arrayNode('cache')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultTrue()
                        ->end()
                        ->integerNode('ttl')
                            ->defaultValue(60)
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('formatter')
                    ->children()
                        ->enumNode('type')
                            ->defaultValue('uppercase')
                            ->values(['uppercase'])
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('twitter')
                    ->children()
                        ->scalarNode('base_uri')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('consumer_key')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('consumer_secret')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('token')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                        ->scalarNode('token_secret')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
