<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\functional;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ExceptionProcessingCest
 *
 * @package F1Monkey\RequestHandleBundle\Tests\functional
 */
class ExceptionProcessingCest
{
    /**
     * @param FunctionalTester $I
     */
    public function canReturnInternalServerErrorOnException(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/fail');
        $I->seeResponseCodeIs(Response::HTTP_INTERNAL_SERVER_ERROR);
        $I->seeResponseContainsJson(['message' => 'Internal Server Error']);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canReturnNotFoundError(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendGET('/not-existing-route');
        $I->seeResponseCodeIs(Response::HTTP_NOT_FOUND);
        $I->seeResponseContainsJson(['message' => 'Not Found']);
    }

    /**
     * @param FunctionalTester $I
     */
    public function canReturnValidationErrors(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/', ['name' => '']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
        $I->seeResponseContainsJson(
            [
                'message' => 'Validation error',
                'errors'  => [
                    [
                        'field' => 'name',
                        'message' => 'This value should not be blank.'
                    ],
                ],
            ]
        );
    }
}