<?php

namespace App\Services;

use Alfred\Workflows\Workflow;
use App\Repositories\Problems\ProblemRepositoryInterface;

class ProblemsService implements ServiceInterface
{
    /**
     * @var ProblemRepositoryInterface
     */
    private $repository;

    /**
     * DataStructureService constructor.
     *
     * @param ProblemRepositoryInterface $repository
     */
    public function __construct(ProblemRepositoryInterface $repository)
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
