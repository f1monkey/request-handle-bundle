<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Throwable;

/**
 * Interface ValidationExceptionInterface
 *
 * @package F1Monkey\RequestHandleBundle\Exception\Validation
 */
interface ValidationExceptionInterface extends Throwable
{
    /**
     * @return ConstraintViolationListInterface<ConstraintViolationInterface>
     */
    public function getViolations(): ConstraintViolationListInterface;
}