<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\unit\ArgumentValueResolver;

use Codeception\Test\Unit;
use Exception;
use F1Monkey\RequestHandleBundle\ArgumentValueResolver\RequestDeserializationValueResolver;
use F1Monkey\RequestHandleBundle\Exception\InvalidRequestBodyException;
use F1Monkey\RequestHandleBundle\Service\RequestDeserializerInterface;
use PHPUnit\Framework\ExpectationFailedException;
use stdClass;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class RequestDeserializationValueResolverTest
 *
 * @package F1Monkey\RequestHandleBundle\Tests\unit\ArgumentValueResolver
 */
class RequestDeserializationValueResolverTest extends Unit
{
    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testSupportsRequiredClass()
    {
        /** @var RequestDeserializerInterface $deserializer */
        $deserializer = $this->makeEmpty(RequestDeserializerInterface::class);
        /** @var Request $request */
        $request = $this->makeEmpty(Request::class);
        $service = new RequestDeserializationValueResolver($deserializer, stdClass::class);

        $result = $service->supports($request, $this->createArgument(stdClass::class));

        static::assertTrue($result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws Exception
     */
    public function testDoesNotSupportOtherClass()
    {
        $supportedClass   = stdClass::class;
        $unsupportedClass = Request::class;

        /** @var RequestDeserializerInterface $deserializer */
        $deserializer = $this->makeEmpty(RequestDeserializerInterface::class);
        /** @var Request $request */
        $request = $this->makeEmpty(Request::class);
        $service = new RequestDeserializationValueResolver($deserializer, $unsupportedClass);

        $result = $service->supports($request, $this->createArgument($supportedClass));

        static::assertFalse($result);
    }

    /**
     * @throws ExpectationFailedException
     * @throws InvalidRequestBodyException
     * @throws BadRequestException
     */
    public function testCanDeserializeRequest()
    {
        $supportedClass = stdClass::class;
        $expected = new stdClass();

        /** @var RequestDeserializerInterface $deserializer */
        $deserializer = $this->makeEmpty(RequestDeserializerInterface::class, [
            'deserializeRequest' => $expected
        ]);
        /** @var Request $request */
        $request = $this->makeEmpty(Request::class);
        $service = new RequestDeserializationValueResolver($deserializer, $supportedClass);

        $iterator = $service->resolve($request, $this->createArgument($supportedClass));
        static::assertSame($expected, $iterator->current());
    }

    /**
     * @param string $class
     *
     * @return ArgumentMetadata
     * @throws Exception
     */
    protected function createArgument(string $class): ArgumentMetadata
    {
        /** @var ArgumentMetadata $argument */
        $argument = $this->makeEmpty(
            ArgumentMetadata::class,
            [
                'getType' => $class,
            ]
        );

        return $argument;
    }
}