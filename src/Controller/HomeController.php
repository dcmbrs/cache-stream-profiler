<?php

namespace App\Controller;

use App\Service\Cache;
use App\Service\HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    public function __construct(
        protected Cache $cache,
        protected HttpClient $client,
    )
    {
    }

    #[Route('/', name: 'home')]
    public function index()
    {
        $this->cache->test();
        return $this->json([
            'message' => 'Cache WORKS ! Check profiler and cache pool `cache.app`',
            'profiler' => '_profiler/latest?type=request&panel=cache',
        ]);
    }

    #[Route('/stream', name: 'stream')]
    public function teststream()
    {
//        $this->cache->test('before stream');
        $response = new StreamedResponse();
        $response->headers->set('Content-Type', 'text/event-stream');
        $response->setCallback(function () {
            $this->sendSseEvent('message', 'Hello, world!');
            $this->cache->test();
            $this->client->test();
            $this->sendSseEvent('message', 'profiler cache pool `cache.app` empty :(');
            $this->sendSseEvent('message', 'profiler http works ! :)');
        });
        return $response;
    }

    private function sendSseEvent(string $event, string $data): void
    {
        ob_start();
        echo 'event: '.$event."\n";
        echo 'data: '.$data."\n\n";
        ob_flush();
        flush();
        ob_end_clean();
    }


}