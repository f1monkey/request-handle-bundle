<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\functional\Mock;

use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class Controller
 *
 * @package F1Monkey\RequestHandleBundle\Tests\functional\Mock
 */
class Controller
{
    /**
     * @Route("/", name="index", methods={Request::METHOD_POST, Request::METHOD_GET})
     *
     * @param RequestExample $requestExample
     * @param Request        $request
     *
     * @return JsonResponse
     */
    public function index(RequestExample $requestExample, Request $request): JsonResponse
    {
        return new JsonResponse(['ok']);
    }

    /**
     * @Route("/fail", name="fail", methods={Request::METHOD_POST, Request::METHOD_GET})
     *
     * @throws Exception
     */
    public function fail()
    {
        throw new Exception('Error');
    }
}