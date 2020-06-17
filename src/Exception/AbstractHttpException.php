<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception;

use RuntimeException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

/**
 * Class AbstractHttpException
 *
 * @package F1Monkey\RequestHandleBundle\Exception
 */
abstract class AbstractHttpException extends RuntimeException implements
    RequestExceptionInterface,
    HttpExceptionInterface
{
    use HasHeadersTrait;
}