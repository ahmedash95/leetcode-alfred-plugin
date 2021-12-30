<?php

namespace App\Services;

use Alfred\Workflows\Workflow;
use App\Repositories\DailyProblem\DailyProblemRepositoryInterface;

class DailyProblemsService implements ServiceInterface
{
    /**
     * @var DailyProblemRepositoryInterface
     */
    private $repository;

    /**
     * DataStructureService constructor.
     *
     * @param DailyProblemRepositoryInterface $repository
     */
    public function __construct(DailyProblemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function run(string $query, Workflow $workflow)
    {
        $data = $this->repository->search($query);

        foreach ($data as $item) {
            $workflow->result()
                ->icon('favicon.png')
                ->title($item->getName())
                ->subtitle($item->getType())
                ->arg(sprintf('https://leetcode.com%s', $item->getSlug()))
                ->valid(true);
        }
    }
}
