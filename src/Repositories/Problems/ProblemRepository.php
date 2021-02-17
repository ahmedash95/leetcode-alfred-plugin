<?php

namespace App\Repositories\Problems;

use App\Entities\LeetCodeItem;
use App\Entities\LeetCodeType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ProblemRepository implements ProblemRepositoryInterface
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
            'https://leetcode.com/api/problems/all/'
        );

        return $this->hydrate($response->toArray()['stat_status_pairs'] ?? []);
    }

    /**
     * @param string $query
     *
     * @return array
     */
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
            $leetcode->setName($row['stat']['question__title']);
            $leetcode->setType(LeetCodeType::PROBLEM);
            $leetcode->setSlug(sprintf('/problems/%s/', $row['stat']['question__title_slug']));

            $items[] = $leetcode;
        }

        return $items;
    }
}
