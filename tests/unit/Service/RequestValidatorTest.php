<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\unit\Service;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Exception;
use F1Monkey\RequestHandleBundle\Exception\Validation\RequestValidationException;
use F1Monkey\RequestHandleBundle\Service\RequestValidator;
use stdClass;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class RequestValidatorTest
 *
 * @package App\Tests\unit\Service\Service
 */
class RequestValidatorTest extends Unit
{
    /**
     * @throws RequestValidationException
     * @throws Exception
     */
    public function testCannotThrowExceptionOnValidRequest()
    {
        $violations = $this->makeEmpty(
            ConstraintViolationListInterface::class,
            [
                'count' => Expected::atLeastOnce(0),
            ]
        );
        /** @var ValidatorInterface $validator */
        $validator = $this->makeEmpty(
            ValidatorInterface::class,
            [
                'validate' => Expected::once($violations),
            ]
        );

        $service = new RequestValidator($validator);
        $service->validateRequest(new stdClass());
    }

    /**
     * @throws RequestValidationException
     * @throws Exception
     */
    public function testCanThrowExceptionOnInvalidRequest()
    {
        $violations = $this->makeEmpty(
            ConstraintViolationListInterface::class,
            [
                'count' => Expected::atLeastOnce(1),
            ]
        );
        /** @var ValidatorInterface $validator */
        $validator = $this->makeEmpty(
            ValidatorInterface::class,
            [
                'validate' => Expected::once($violations),
            ]
        );

        $service = new RequestValidator($validator);

        $this->expectException(RequestValidationException::class);
        $service->validateRequest(new stdClass());
    }
}