<?php
declare(strict_types=1);

namespace App\Service\Request;
namespace F1Monkey\RequestHandleBundle\Service;

use F1Monkey\RequestHandleBundle\Exception\Validation\RequestValidationException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestValidator
 *
 * @package App\Service\Request
 */
class RequestValidator implements RequestValidatorInterface
{
    /**
     * @var ValidatorInterface
     */
    protected ValidatorInterface $validator;

    /**
     * RequestValidator constructor.
     *
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param object $object
     *
     * @throws RequestValidationException
     */
    public function validateRequest(object $object): void
    {
        $violations = $this->validator->validate($object);
        if ($violations->count()) {
            throw new RequestValidationException($violations, 'Validation error');
        }
    }
}