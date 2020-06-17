<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Service;

use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

/**
 * Interface LogContextProviderInterface
 *
 * @package F1Monkey\RequestHandleBundle\Service
 */
class LogContextProvider implements LogContextProviderInterface
{
    /**
     * @param Throwable $exception
     * @param Request   $request
     *
     * @return string
     */
    public function getLogLevel(Throwable $exception, Request $request = null): string
    {
        if ($exception instanceof HttpExceptionInterface) {
            return LogLevel::INFO;
        }

        return LogLevel::CRITICAL;
    }

    /**
     * @param Throwable $exception
     * @param Request|null   $request
     *
     * @return array
     */
    public function getLogContext(Throwable $exception, Request $request = null): array
    {
        if ($exception instanceof HttpExceptionInterface) {
            return [];
        }

        return [
            'trace' => $exception->getTrace(),
        ];
    }
}