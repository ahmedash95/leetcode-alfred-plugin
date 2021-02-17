<?php

namespace App\Services;

use Alfred\Workflows\Workflow;

class ChallengesService implements ServiceInterface
{
    public function run(string $query, Workflow $workflow)
    {
        $dailyChallengeLink = sprintf('https://leetcode.com/explore/challenge/card/%s-leetcoding-challenge-%s/', strtolower(date('F')), date('Y'));

        $workflow->result()
            ->icon('favicon.png')
            ->title(sprintf('%s challenge %s', date('F'), date('Y')))
            ->autocomplete('da')
            ->subtitle('Leetcode monthly challenge')
            ->arg($dailyChallengeLink)
            ->valid(true);
    }
}
