<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\DependencyInjection;

use RuntimeException;
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
     * @throws RuntimeException
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('request_handle');
        $rootNode = $treeBuilder->getRootNode()->children();

        $rootNode->end();

        return $treeBuilder;
    }
}
