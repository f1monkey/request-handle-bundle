<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\unit\Factory;

use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Exception;
use F1Monkey\RequestHandleBundle\Exception\UserFriendlyExceptionInterface;
use F1Monkey\RequestHandleBundle\Exception\Validation\RequestValidationException;
use F1Monkey\RequestHandleBundle\Factory\JsonErrorResponseFactory;
use JMS\Serializer\ArrayTransformerInterface;
use PHPUnit\Framework\ExpectationFailedException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * Class JsonErrorResponseFactoryTest
 *
 * @package F1Monkey\RequestHandleBundle\Tests\unit\Factory
 */
class JsonErrorResponseFactoryTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateErrorResponseFromGenericException()
    {
        $factory = new JsonErrorResponseFactory($this->createTranslator(), $this->createTransformer());

        $exception = new Exception();
        $result    = $factory->createErrorResponse($exception);

        static::assertSame('Internal Server Error', $result->getMessage());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateErrorResponseFromUserFriendlyException()
    {
        $message   = 'Message';
        $ex        = new class extends Exception implements UserFriendlyExceptionInterface {
        };
        $exception = new $ex($message);
        $factory   = new JsonErrorResponseFactory($this->createTranslator($message), $this->createTransformer());

        $result = $factory->createErrorResponse($exception);

        static::assertSame($exception->getMessage(), $result->getMessage());
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testCanCreateErrorResponseFromRequestValidationException()
    {
        $exceptionMessage = 'Message';

        $field      = 'field';
        $message    = 'message';
        $violation  = $this->makeEmpty(
            ConstraintViolation::class,
            [
                'getPropertyPath' => $field,
                'getMessage'      => $message,
            ]
        );
        /** @var ConstraintViolationListInterface $violations */
        $violations = $this->makeEmpty(
            ConstraintViolationList::class,
            [
                'getIterator' => new ArrayCollection(
                    [
                        $violation
                    ]
                ),
            ]
        );
        $exception  = new RequestValidationException($violations, $exceptionMessage);
        $factory    = new JsonErrorResponseFactory(
            $this->createTranslator($exceptionMessage),
            $this->createTransformer()
        );

        $result = $factory->createErrorResponse($exception);

        static::assertSame($exception->getMessage(), $result->getMessage());
        static::assertSame($violation->getPropertyPath(), $result->getErrors()->first()->getField());
        static::assertSame($violation->getMessage(), $result->getErrors()->first()->getMessage());
    }

    /**
     * @param string|null $message
     *
     * @return TranslatorInterface
     * @throws Exception
     */
    protected function createTranslator(string $message = null): TranslatorInterface
    {
        /** @var TranslatorInterface $translator */
        $translator = $this->makeEmpty(
            TranslatorInterface::class,
            [
                'trans' => $message,
            ]
        );

        return $translator;
    }

    /**
     * @return ArrayTransformerInterface
     * @throws Exception
     */
    protected function createTransformer(): ArrayTransformerInterface
    {
        /** @var ArrayTransformerInterface $transformer */
        $transformer = $this->makeEmpty(ArrayTransformerInterface::class);

        return $transformer;
    }

    /**
     *
     */
    public function exceptionProvider()
    {

    }
}