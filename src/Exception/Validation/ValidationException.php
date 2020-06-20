<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use Stringable;
use Symfony\Component\Validator\ConstraintViolationInterface;
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
     * @param ConstraintViolationListInterface<ConstraintViolationInterface> $violations
     * @param string                                                         $message
     * @param int                                                            $code
     * @param Throwable|null                                                 $previous
     */
    public function __construct(
        ConstraintViolationListInterface $violations,
        $message = '',
        $code = 0,
        Throwable $previous = null
    )
    {
        if ($message === '') {
            if ($violations instanceof Stringable) {
                $message = sprintf('Validation error: %s', (string)$violations);
            } else {
                $message = 'Validation error';
            }
        }

        $this->violations = $violations;
        parent::__construct($message, $code, $previous);
    }
}