<?php

namespace App\Repositories\DataStructures;

use App\Entities\LeetCodeItem;
use App\Entities\LeetCodeType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DataStructuresRepository implements DataStructureRepositoryInterface
{
    /**
     * @var HttpClient
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(): array
    {
        $response = $this->client->request(
            'GET',
            'https://leetcode.com/problems/api/tags/'
        );

        return $this->hydrate($response->toArray()['topics'] ?? []);
    }

    public function search($query): array
    {
        $data = $this->get();

        if (empty($query)) {
            return $data;
        }

        return array_filter($data, function (LeetCodeItem $item) use ($query) {
            return strpos(strtolower($item->getName()), trim($query)) !== false;
        });
    }

    /**
     * @param array $data
     *
     * @return LeetCodeItem[]
     */
    private function hydrate(array $data)
    {
        $items = [];
        foreach ($data as $row) {
            $leetcode = new LeetCodeItem();
            $leetcode->setName($row['name']);
            $leetcode->setType(LeetCodeType::CATEGORY);
            $leetcode->setSlug(sprintf('/tag/%s/', $row['slug']));

            $items[] = $leetcode;
        }

        return $items;
    }
}
