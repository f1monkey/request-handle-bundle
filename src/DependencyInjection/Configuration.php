<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package F1Monkey\RequestHandleBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('request_handle');

        $rootNode    = $treeBuilder->getRootNode()->children();
        $this->addValueResolverSettings($rootNode);
        $this->addRequestValidatorSettings($rootNode);
        $rootNode->end();

        return $treeBuilder;
    }

    /**
     * @param NodeBuilder $node
     */
    protected function addValueResolverSettings(NodeBuilder $node)
    {
        $node->arrayNode('value_resolver')
             ->isRequired()
             ->children()
                ->scalarNode('supported_class')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
             ->end();
    }

    /**
     * @param NodeBuilder $node
     */
    protected function addRequestValidatorSettings(NodeBuilder $node)
    {
        $node->arrayNode('request_validator')
                ->isRequired()
                    ->children()
                    ->scalarNode('supported_class')
                    ->cannotBeEmpty()
                    ->isRequired()
                ->end()
             ->end();
    }
}
