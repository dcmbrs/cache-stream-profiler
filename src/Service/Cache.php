<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Log\LoggerInterface;

class Cache
{
    public function __construct(protected CacheItemPoolInterface $cache, private LoggerInterface $logger)
    {
    }

    public function test(string $key = 'ping'): bool
    {
        $this->logger->info('Cache test for adapter: ' . get_class($this->cache));
        try {
            if (!$this->cache->hasItem($key)) {
                $item = $this->cache->getItem($key);
                $cached = 'pong';
                $item->set($cached);
                return $this->cache->save($item);
            }
        } catch (\Throwable $e) {
            $this->logger->error('Cache test failed: ' . $e->getMessage());
            dump($e);
        }

        return false;
    }
}