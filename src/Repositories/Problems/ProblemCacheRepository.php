<?php

namespace App\Repositories\Problems;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProblemCacheRepository extends ProblemRepository
{
    /**
     * @var CacheInterface
     */
    private $cache;

    public function __construct(HttpClientInterface $client, CacheInterface $cache)
    {
        parent::__construct($client);

        $this->cache = $cache;
    }

    public function get(): array
    {
        return $this->cache->get('problems', function (ItemInterface $item) {
            $item->expiresAfter(172800); // 48 hours

            return parent::get();
        });
    }
}
