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
    public function getLogLevel(Throwable $exception, Request $request): string
    {
        if ($exception instanceof HttpExceptionInterface) {
            return LogLevel::INFO;
        }

        return LogLevel::CRITICAL;
    }

    /**
     * @param Throwable $exception
     * @param Request   $request
     *
     * @return array
     */
    public function getLogContext(Throwable $exception, Request $request): array
    {
        $context = [
            'url'   => $request->getPathInfo(),
            'route' => $request->attributes->get('_controller'),
        ];

        if (!$exception instanceof HttpExceptionInterface) {
            $context['request'] = (string)$request;
            $context['trace'] = $exception->getTrace();
        }

        return $context;
    }
}