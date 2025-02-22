<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class HttpClient
{
    public function __construct(private HttpClientInterface $client)
    {
    }

    public function test(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.github.com/repos/symfony/symfony-docs',
            ['timeout' => 1, 'max_duration' => 1]
        );

        try {
            return $response->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}