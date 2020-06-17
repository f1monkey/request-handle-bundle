<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Service;

use F1Monkey\RequestHandleBundle\Exception\InvalidRequestBodyException;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\Exception\RuntimeException as JMSRuntimeException;
use JMS\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JsonRequestDeserializer
 *
 * @package App\Service\Request
 */
class JsonRequestDeserializer implements RequestDeserializerInterface
{
    /**
     * @var ArrayTransformerInterface
     */
    protected ArrayTransformerInterface $arrayTransformer;

    /**
     * @var SerializerInterface
     */
    protected SerializerInterface $serializer;

    /**
     * RequestDeserializer constructor.
     *
     * @param ArrayTransformerInterface $arrayTransformer
     * @param SerializerInterface       $serializer
     */
    public function __construct(ArrayTransformerInterface $arrayTransformer, SerializerInterface $serializer)
    {
        $this->arrayTransformer = $arrayTransformer;
        $this->serializer       = $serializer;
    }

    /**
     * @param Request $request
     * @param string  $type
     *
     * @return object
     * @throws InvalidRequestBodyException
     * @throws BadRequestException
     */
    public function deserializeRequest(Request $request, string $type): object
    {
        try {
            if ($request->isMethodSafe()) {
                $result = $this->arrayTransformer->fromArray($request->query->all(), $type);
            } else {
                $result = $this->serializer->deserialize(
                    $request->getContent(),
                    $type,
                    'json'
                );
            }

            return $result;
        } catch (JMSRuntimeException $e) {
            throw new InvalidRequestBodyException($e->getMessage());
        }
    }
}