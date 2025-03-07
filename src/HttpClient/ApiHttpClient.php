<?php

namespace App\HttpClient;

use App\HttpClient\ApiHttpClient;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiHttpClient extends AbstractController
{
    private $httpClient;

    public function __construct(HttpClientInterface $jph)
    {
        $this->httpClient = $jph;
    }

    // > API endpoints + API Key + data
    public function getYTStats(string $channelId){

        $response = $this->httpClient->request('GET', "youtube/v3/channels?part=statistics&id=".$channelId."&key=".$_ENV["API_KEY_YT"], [
            'verify_peer' => false,
        ]);

        return $response->toArray();
    }
}
