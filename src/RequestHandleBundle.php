<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle;

use F1Monkey\RequestHandleBundle\DependencyInjection\CompilerPass\ExceptionLoggerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class RequestHandleBundle
 *
 * @package F1Monkey\RequestHandleBundle
 */
class RequestHandleBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExceptionLoggerPass());
    }
}
