<?php


namespace Tests\Api;

use Codeception\Util\HttpCode;
use Tests\Support\ApiTester;

class CreateUserCest
{
    public function _before(ApiTester $I)
    {
    }

    // tests
    public function tryToTest(ApiTester $I)
    {
        $I->haveHttpHeader('Content-Type', 'application/x-www-form-urlencoded');
        $I->sendPost('/register', [
            'name' => 'davert', 
            'email' => 'davert@codeception.com',
            'firstname' => 'test',
            'lastname' => 'test',
            'password' => '1234',
        ]);
        // $I->seeResponseCodeIsSuccessful();
        $I->seeResponseCodeIs(HttpCode::BAD_REQUEST);
        $I->seeResponseIsJson();
        // $I->seeResponseContains('{"result":"ok"}');
    }
}
