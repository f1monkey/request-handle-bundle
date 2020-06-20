<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

/**
 * Trait HasViolationsTrait
 *
 * @package F1Monkey\RequestHandleBundle\Exception\Validation
 */
trait HasViolationsTrait
{
    /**
     * @var ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    protected ConstraintViolationListInterface $violations;

    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}