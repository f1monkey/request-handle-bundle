<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\ArgumentValueResolver;

use F1Monkey\RequestHandleBundle\Exception\InvalidRequestBodyException;
use F1Monkey\RequestHandleBundle\Service\RequestDeserializerInterface;
use Generator;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class RequestDeserializationValueResolver
 *
 * @package App\ArgumentValueResolver
 */
class RequestDeserializationValueResolver implements ArgumentValueResolverInterface
{
    /**
     * @var RequestDeserializerInterface
     */
    protected RequestDeserializerInterface $requestDeserializer;

    /**
     * @var string
     */
    protected string $supportedClass;

    /**
     * V1RequestDeserializationResolver constructor.
     *
     * @param RequestDeserializerInterface $requestDeserializer
     * @param string                       $supportedClass
     */
    public function __construct(RequestDeserializerInterface $requestDeserializer, string $supportedClass)
    {
        $this->requestDeserializer = $requestDeserializer;
        $this->supportedClass      = $supportedClass;
    }

    /**
     * Whether this resolver can resolve the value for the given ArgumentMetadata.
     *
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return bool
     */
    public function supports(Request $request, ArgumentMetadata $argument)
    {
        if ($argument->getType() === null) {
            return false;
        }

        return is_a($argument->getType(), $this->supportedClass, true);
    }

    /**
     * Returns the possible value(s).
     *
     * @param Request          $request
     * @param ArgumentMetadata $argument
     *
     * @return Generator|object[]
     * @throws InvalidRequestBodyException
     * @throws BadRequestException
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $argumentType = $argument->getType();
        if ($argumentType === null) {
            throw new InvalidArgumentException(
                sprintf('Expected string, got "%s"', gettype($argumentType))
            );
        }

        yield $this->requestDeserializer->deserializeRequest($request, $argumentType);
    }
}