<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Service;

use Symfony\Component\HttpFoundation\Request;
use Throwable;

/**
 * Interface LogContextProviderInterface
 *
 * @package F1Monkey\RequestHandleBundle\Service
 */
interface LogContextProviderInterface
{
    /**
     * @param Throwable $exception
     * @param Request   $request
     *
     * @return string
     */
    public function getLogLevel(Throwable $exception, Request $request): string;

    /**
     * @param Throwable $exception
     * @param Request   $request
     *
     * @return array<string, mixed>
     */
    public function getLogContext(Throwable $exception, Request $request): array;
}