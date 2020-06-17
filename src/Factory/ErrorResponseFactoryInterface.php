<?php
declare(strict_types=1);

namespace App\Factory\Api\V1;

namespace F1Monkey\RequestHandleBundle\Factory;
use F1Monkey\RequestHandleBundle\Dto\ErrorResponse;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 * Interface ErrorResponseFactoryInterface
 *
 * @package App\Factory\Api\V1
 */
interface ErrorResponseFactoryInterface
{
    /**
     * @param Throwable $exception
     *
     * @return ErrorResponse
     */
    public function createErrorResponse(Throwable $exception): object;

    /**
     * @param object $errorResponse
     * @param int    $httpStatusCode
     *
     * @return Response
     */
    public function createResponse(object $errorResponse, int $httpStatusCode): Response;
}