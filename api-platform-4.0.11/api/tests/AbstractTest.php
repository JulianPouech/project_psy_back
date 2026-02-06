<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;

abstract class AbstractTest extends WebTestCase
{
    private ?string $token = null;


    /**
     * @return array<string,Symfony\Component\DependencyInjection\Loader\Configurator\EnvConfigurator>
     */
    private function getUserData(bool $isAdmin): array {
        if($isAdmin)
        {
            return [
                'email' => $_ENV['ADMIN_EMAIL'],
                'password' => $_ENV['ADMIN_PASSWORD']
            ];
        }

        return [
                'email' => $_ENV['USER_EMAIL'],
                'password' => $_ENV['USER_PASSWORD']
        ];

    }

    protected function createClientWithCredentials(?string $token = null): KernelBrowser
    {
        self::ensureKernelShutdown();
        $token = $token ?: $this->getToken();
        $client = static::createClient();
        $client->catchExceptions(false);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $this->getToken()));
        return $client;
    }

    /**
    * @param array<string> $json Description
    */
    protected function login(bool $isAdmin = false, array $json = []): void
    {
        $client = static::createClient();

        if(count($json) == 0)
        {
            $client->jsonRequest('POST', '/api/auth', $this->getUserData($isAdmin));
        }
        else
        {
            $client->jsonRequest('POST','/api/auth', $json);
        }
        $cookie = $client->getCookieJar()->get('Authorization','/','localhost');

        if($cookie instanceof Cookie)
        {
            $this->token = $cookie->getValue();
        }

    }
    protected  function getToken(): ?string
    {
        return $this->token;
    }

}
