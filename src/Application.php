<?php

namespace App;

use Alfred\Workflows\Workflow;
use App\Services\ServiceInterface;

class Application
{
    private $query;

    private $workflow;

    private $services = [];

    public function __construct($query, Workflow $workflow)
    {
        $this->query = $query;
        $this->workflow = $workflow;
    }

    public function addService(ServiceInterface $service) {
        $this->services[] = $service;
    }

    public function run()
    {
        foreach($this->services as $service) {
        	$service->run($this->query, $this->workflow);
		}

        return $this->workflow->output();
    }
}
