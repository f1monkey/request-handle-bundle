<?php
declare(strict_types=1);

namespace F1Monkey\RequestHandleBundle\Tests\functional;

use FunctionalTester;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class RequestValidationCest
 *
 * @package F1Monkey\RequestHandleBundle\Tests\functional
 *
 */
class RequestValidationCest
{
    /**
     * @param FunctionalTester $I
     */
    public function canPassValidRequest(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/', ['name' => 'user']);
        $I->seeResponseCodeIs(Response::HTTP_OK);
    }

    /**
     * @param FunctionalTester $I
     */
    public function cannotPassInvalidRequest(FunctionalTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST('/', ['name' => '']);
        $I->seeResponseCodeIs(Response::HTTP_BAD_REQUEST);
    }
}