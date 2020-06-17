<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\unit\Service;

use Codeception\Stub\Expected;
use Codeception\Test\Unit;
use Exception;
use F1Monkey\RequestHandleBundle\Exception\InvalidRequestBodyException;
use F1Monkey\RequestHandleBundle\Service\JsonRequestDeserializer;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\Exception\RuntimeException as JMSRuntimeException;
use JMS\Serializer\SerializerInterface;
use PHPUnit\Framework\ExpectationFailedException;
use stdClass;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class RequestDeserializerTest
 *
 * @package App\Tests\unit\Service\Service
 */
class JsonRequestDeserializerTest extends Unit
{
    /**
     * @throws InvalidRequestBodyException
     * @throws ExpectationFailedException
     * @throws BadRequestException
     * @throws Exception
     */
    public function testCanDeserializeRequestQuery()
    {
        $expected = new stdClass();
        $service  = new JsonRequestDeserializer(
            $this->createArrayTransformerMock(1, $expected),
            $this->createSerializerMock(0)
        );

        $result = $service->deserializeRequest($this->createGetRequestMock(), 'type');
        static::assertSame($expected, $result);
    }

    /**
     * @throws BadRequestException
     * @throws ExpectationFailedException
     * @throws InvalidRequestBodyException
     * @throws Exception
     */
    public function testCanDeserializeRequestBody()
    {
        $expected = new stdClass();
        $service  = new JsonRequestDeserializer(
            $this->createArrayTransformerMock(0),
            $this->createSerializerMock(1, $expected)
        );

        $result = $service->deserializeRequest($this->createPostRequestMock(), 'type');
        static::assertSame($expected, $result);
    }

    /**
     * @throws BadRequestException
     * @throws InvalidRequestBodyException
     * @throws Exception
     */
    public function testCanThrowExceptionIfRequestQueryIsInvalid()
    {
        $expected = function () {
            throw new JMSRuntimeException('');
        };
        $service  = new JsonRequestDeserializer(
            $this->createArrayTransformerMock(1, $expected),
            $this->createSerializerMock(0)
        );

        $this->expectException(InvalidRequestBodyException::class);
        $service->deserializeRequest($this->createGetRequestMock(), 'type');
    }

    /**
     * @throws BadRequestException
     * @throws InvalidRequestBodyException
     * @throws Exception
     */
    public function testCanThrowExceptionIfRequestBodyIsInvalid()
    {
        $expected = function () {
            throw new JMSRuntimeException('');
        };
        $service  = new JsonRequestDeserializer(
            $this->createArrayTransformerMock(0),
            $this->createSerializerMock(1, $expected)
        );

        $this->expectException(InvalidRequestBodyException::class);
        $service->deserializeRequest($this->createPostRequestMock(), 'type');
    }

    /**
     * @return Request
     * @throws Exception
     */
    protected function createGetRequestMock(): Request
    {
        /** @var Request $result */
        $result        = $this->makeEmpty(
            Request::class,
            [
                'isMethodSafe' => true,
            ]
        );
        $result->query = $this->makeEmpty(
            ParameterBag::class,
            [
                'all' => [],
            ]
        );

        return $result;
    }

    /**
     * @return Request
     * @throws Exception
     */
    protected function createPostRequestMock(): Request
    {
        /** @var Request $result */
        $result = $this->makeEmpty(
            Request::class,
            [
                'isMethodSafe' => false,
                'getContent'   => '',
            ]
        );

        return $result;
    }

    /**
     * @param int        $count
     * @param mixed|null $expected
     *
     * @return ArrayTransformerInterface
     * @throws Exception
     */
    protected function createArrayTransformerMock(int $count, $expected = null): ArrayTransformerInterface
    {
        /** @var ArrayTransformerInterface $result */
        $result = $this->makeEmpty(
            ArrayTransformerInterface::class,
            [
                'fromArray' => $count ? Expected::exactly($count, $expected) : Expected::never(),
            ]
        );

        return $result;
    }

    /**
     * @param int        $count
     * @param mixed|null $expected
     *
     * @return SerializerInterface
     * @throws Exception
     */
    protected function createSerializerMock(int $count, $expected = null): SerializerInterface
    {
        /** @var SerializerInterface $result */
        $result = $this->makeEmpty(
            SerializerInterface::class,
            [
                'deserialize' => $count ? Expected::exactly($count, $expected) : Expected::never(),
            ]
        );

        return $result;
    }
}