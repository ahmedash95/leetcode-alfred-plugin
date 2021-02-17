<?php

namespace App\Services;

use Alfred\Workflows\Workflow;

interface ServiceInterface
{
    public function run(string $query, Workflow $workflow);
}
