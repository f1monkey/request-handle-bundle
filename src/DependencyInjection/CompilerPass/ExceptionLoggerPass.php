<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\DependencyInjection\CompilerPass;

use F1Monkey\RequestHandleBundle\EventListener\ExceptionLogListener;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExceptionLoggerPass
 *
 * @package F1Monkey\RequestHandleBundle\DependencyInjection\CompilerPass
 */
class ExceptionLoggerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container): void
    {
        $this->injectLogger($container);
    }

    /**
     * @param ContainerBuilder $container
     */
    protected function injectLogger(ContainerBuilder $container)
    {
        $listener = $container->getDefinition(ExceptionLogListener::class);
        foreach ($listener->getMethodCalls() as [$method, $arguments]) {
            if ($method === 'setLogger') {
                return;
            }
        }

        if ($container->hasParameter('f1monkey.exception_log.logger')) {
            $logger = $container->getParameter('f1monkey.exception_log.logger');
        } else {
            $logger = 'logger';
        }

        $listener->addMethodCall(
            'setLogger',
            [
                new Reference($logger),
            ]
        );
    }
}