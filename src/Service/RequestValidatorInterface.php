<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Service;

/**
 * Interface RequestValidatorInterface
 *
 * @package App\Service\Request
 */
interface RequestValidatorInterface
{
    /**
     * @param object $object
     *
     * @throws RequestValidationException
     */
    public function validateRequest(object $object): void;
}