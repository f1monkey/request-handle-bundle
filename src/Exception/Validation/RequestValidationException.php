<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use F1Monkey\RequestHandleBundle\Exception\HasHeadersTrait;
use F1Monkey\RequestHandleBundle\Exception\RequestExceptionInterface;
use F1Monkey\RequestHandleBundle\Exception\UserFriendlyExceptionInterface;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class RequestValidationException
 *
 * @package F1Monkey\RequestHandleBundle\Exception\Validation
 */
class RequestValidationException extends RuntimeException implements
    RequestExceptionInterface,
    ValidationExceptionInterface,
    UserFriendlyExceptionInterface,
    HttpExceptionInterface
{
    use HasHeadersTrait;
    use HasViolationsTrait;

    /**
     * RequestValidationException constructor.
     *
     * @param ConstraintViolationListInterface $violations
     * @param string                           $message
     * @param int                              $code
     * @param Throwable|null                   $previous
     */
    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = '',
        $code = 0,
        Throwable $previous = null
    )
    {
        $this->violations = $violations;
        $message          = $message ?: 'Validation error';
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return Response::HTTP_BAD_REQUEST;
    }
}