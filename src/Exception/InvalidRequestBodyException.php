<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Exception;

use Symfony\Component\HttpFoundation\Response;

/**
 * Class InvalidRequestBodyException
 *
 * @package F1Monkey\RequestHandleBundle\Exception
 */
class InvalidRequestBodyException extends AbstractHttpException
{
    /**
     * @return int An HTTP response status code
     */
    public function getStatusCode()
    {
        return Response::HTTP_BAD_REQUEST;
    }
}