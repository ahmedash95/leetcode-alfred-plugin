<?php

namespace App\Services;

use Alfred\Workflows\Workflow;
use App\Repositories\DataStructures\DataStructureRepositoryInterface;

class DataStructureService implements ServiceInterface
{
    /**
     * @var DataStructureRepositoryInterface
     */
    private $repository;

    /**
     * DataStructureService constructor.
     *
     * @param DataStructureRepositoryInterface $repository
     */
    public function __construct(DataStructureRepositoryInterface $repository)
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
