<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\DependencyInjection;

use Exception;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

/**
 * Class AddressExtension
 *
 * @package F1Monkey\RequestHandleBundle\DependencyInjection
 */
class RequestHandleExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $processor = new Processor();
        $configuration = new Configuration();

        $config = $processor->processConfiguration($configuration, $configs);
        $this->processValueResolverConfig($container, $config['value_resolver']);
        $this->processRequestValidatorConfig($container, $config['request_validator']);

        if (isset($config['exception_log'])) {
            $this->processExceptionLogConfig($container, $config['exception_log']);
        }

        $loader = new YamlFileLoader(
            $container, new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function processValueResolverConfig(ContainerBuilder $container, array $config)
    {
        $container->setParameter('f1monkey.request_handle.value_resolver.request_class', $config['request_class']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function processRequestValidatorConfig(ContainerBuilder $container, array $config)
    {
        $container->setParameter('f1monkey.request_handle.request_validator.request_class', $config['request_class']);
    }

    /**
     * @param ContainerBuilder $container
     * @param array            $config
     */
    protected function processExceptionLogConfig(ContainerBuilder $container, array $config)
    {
        $container->setParameter('f1monkey.exception_log.logger', $config['logger']);
    }
}