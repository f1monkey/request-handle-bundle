<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Trait HasViolationsTrait
 *
 * @package F1Monkey\RequestHandleBundle\Exception\Validation
 */
trait HasViolationsTrait
{
    /**
     * @var ConstraintViolationListInterface
     */
    protected ConstraintViolationListInterface $violations;

    /**
     * @return ConstraintViolationListInterface
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}