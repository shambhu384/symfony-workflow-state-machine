<?php

namespace App;

use App\Exception\BadWorkflow;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Order {

    public $state;

    public $customer;

    public $picker;

    public $items;

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $expectedClass = MethodMarkingStore::Class;
        $callerFunction = debug_backtrace()[1]['class'] ?? debug_backtrace()[0]['class'] ?? '';

        if($expectedClass !== $callerFunction) {
            throw BadWorkflow::orderStateCanOnlyBeSetFromWorkflow($callerFunction);
        }
        $this->state = $state;
    }
}
