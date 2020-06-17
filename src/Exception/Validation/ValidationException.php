<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Class ValidationException
 *
 * @package F1Monkey\RequestHandleBundle\Exception\Validation
 */
class ValidationException extends \RuntimeException implements ValidationExceptionInterface
{
    use HasViolationsTrait;

    /**
     * ValidationException constructor.
     *
     * @param ConstraintViolationListInterface $violations
     * @param string                           $message
     * @param int                              $code
     * @param Throwable|null                   $previous
     */
    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = "",
        $code = 0,
        Throwable $previous = null
    )
    {
        $this->violations = $violations;
        $message          = $message ?: sprintf('Validation error: %', (string)$violations);
        parent::__construct($message, $code, $previous);
    }
}