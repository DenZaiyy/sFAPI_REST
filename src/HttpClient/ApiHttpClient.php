<?php

namespace App\HttpClient;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ApiHttpClient extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $jph)
    {
        $this->httpClient = $jph;
    }

    public function getUsers()
    {
        $response = $this->httpClient->request('GET', '?results=10', [
            'verify_peer' => false,
        ]);

        return $response->toArray();
    }
}
