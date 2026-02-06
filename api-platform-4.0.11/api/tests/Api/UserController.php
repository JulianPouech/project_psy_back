<?php

namespace App\Tests\Api;

use App\Tests\AbstractTest;

class UserController extends AbstractTest
{
    public function testWorngAuth(): void
    {
        $this->login(false, [
            "email" => "test",
            "password" => "password"
        ]);
        $this->assertResponseStatusCodeSame(401);
    }

    public function testAuth(): void {
        $this->login(false);
        $this->assertResponseHasCookie('Authorization');
    }
}
