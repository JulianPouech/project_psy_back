<?php

namespace App\Tests\Api;

use App\Tests\AbstractTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

class PatientController extends AbstractTest
{

    public function testGetPatients(): void
    {

        $this->login(false);
        $user = $this->createClientWithCredentials();
        $user->request('GET', 'api/patients');
        $this->assertResponseStatusCodeSame(200);
        $data = $user->getResponse()->getContent();
        $this->assertJson($data);
        $this->assertJsonStringEqualsJsonFile(__DIR__.'/json/testGetPatients.json', $data)
        ;
    }

    public function testCeatePatient(){
        $this->login(false);
        $client = $this->createClientWithCredentials();
        $client->jsonRequest("POST",'api/patients',[
            "firstName" => "firstName +100",
            "lastName" => "lastName +100",
            "phone" => "",
            "Address" => "test",
            "city" => "testland",
            "Postal code" => "09330"
        ]);
        $this->assertResponseStatusCodeSame(201);
    }

    public function testUpdatePatient() {
        $this->login(false);
        $client = $this->createClientWithCredentials();
        $client->jsonRequest("PATCH", 'api/patients/21',
            [
                "firstName" => "test"
            ]);
        $this->assertResponseStatusCodeSame(200);
    }

    public function testUpdatePatientBad() {
        $this->login(false);
        $client = $this->createClientWithCredentials();
        $client->jsonRequest('PATCH', 'api/patients/20' ,[
            "firstName" => "True",
            "lastName" => "Bigchuck",
        ]);
        $this->assertResponseStatusCodeSame(403);
    }

    public function testIndexNoAuth(): void {
        $client = static::createClient();
        $client->request('GET', 'api/patients',);
        $this->assertResponseStatusCodeSame(expectedCode: 401);
    }

    public function testDeletePatient(): void
    {
        $this->login(false);
        $client = $this->createClientWithCredentials();
        $client->request('DELETE', 'api/patients/1');
        $this->assertResponseStatusCodeSame(expectedCode: 403);
    }
}
