<?php

namespace App\Repositories\DataStructures;

use App\Entities\LeetCodeItem;
use App\Entities\LeetCodeType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DataStructuresCacheRepository extends DataStructuresRepository
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
		return $this->cache->get('data_structures', function (ItemInterface $item) {
			$item->expiresAfter(172800); // 48 hours

			return parent::get();
		});
	}
}