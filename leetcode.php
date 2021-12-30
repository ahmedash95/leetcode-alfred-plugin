<?php

use Alfred\Workflows\Workflow;
use App\Application;
use App\Repositories\DailyProblem\DailyProblemRepository;
use App\Repositories\DataStructures\DataStructuresCacheRepository;
use App\Repositories\Problems\ProblemCacheRepository;
use App\Services\ChallengesService;
use App\Services\DailyProblemsService;
use App\Services\DataStructureService;
use App\Services\ProblemsService;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\HttpClient\HttpClient;

require __DIR__.'/vendor/autoload.php';

if (count($argv) > 0) {
    array_shift($argv);
}
$query = strtolower(implode(' ', $argv));

$app = new Application($query, new Workflow());
$app->addService(new DailyProblemsService(new DailyProblemRepository(HttpClient::create())));
$app->addService(new DataStructureService(new DataStructuresCacheRepository(HttpClient::create(), new FilesystemAdapter())));
$app->addService(new ProblemsService(new ProblemCacheRepository(HttpClient::create(), new FilesystemAdapter())));
echo $app->run();
