<?php

namespace App;

use App\Exception\BadWorkflow;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Customer {

    public $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
