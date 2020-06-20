<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\EventListener;

use F1Monkey\RequestHandleBundle\Service\LogContextProviderInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * Class ExceptionLogListener
 *
 * @package F1Monkey\RequestHandleBundle\EventListener
 */
class ExceptionLogListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    /**
     * @var LogContextProviderInterface
     */
    protected LogContextProviderInterface $logContextProvider;

    /**
     * ExceptionLogListener constructor.
     *
     * @param LogContextProviderInterface $logContextProvider
     */
    public function __construct(LogContextProviderInterface $logContextProvider)
    {
        $this->logContextProvider = $logContextProvider;
    }

    /**
     * @param ExceptionEvent $event
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $request   = $event->getRequest();

        $this->logger->log(
            $this->logContextProvider->getLogLevel($exception, $request),
            $exception->getMessage(),
            $this->logContextProvider->getLogContext($exception, $request)
        );
    }
}