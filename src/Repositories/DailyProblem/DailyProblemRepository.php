<?php

namespace App\Repositories\DailyProblem;

use App\Entities\LeetCodeItem;
use App\Entities\LeetCodeType;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class DailyProblemRepository implements DailyProblemRepositoryInterface
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
        $response = $this->client->request('POST', 'https://leetcode.com/graphql', [
            'json' => [
                'query' => 'query questionOfToday {activeDailyCodingChallengeQuestion {link question { title }}}',
            ],
        ]);

        return $this->hydrate($response->toArray()['data']['activeDailyCodingChallengeQuestion'] ?? null);
    }

    /**
     * @param string $query
     *
     * @return array
     */
    public function search($query): array
    {
        return $this->get();
    }

    /**
     * @param array $data
     *
     * @return LeetCodeItem[]
     */
    private function hydrate(array $data)
    {
        if ($data === null) {
            return [];
        }

        $leetcode = new LeetCodeItem();
        $leetcode->setName($data['question']['title']);
        $leetcode->setType(LeetCodeType::PROBLEM_OF_THE_DAY);
        $leetcode->setSlug($data['link']);

        return [$leetcode];
    }
}
