<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Service;

use F1Monkey\RequestHandleBundle\Exception\InvalidRequestBodyException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestDeserializerInterface
 *
 * @package F1Monkey\RequestHandleBundle\Service
 */
interface RequestDeserializerInterface
{
    /**
     * @param Request $request
     * @param string  $type
     *
     * @return object
     * @throws InvalidRequestBodyException
     * @throws BadRequestException
     */
    public function deserializeRequest(Request $request, string $type): object;
}