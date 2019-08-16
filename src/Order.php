<?php

namespace App;

use App\Exception\BadWorkflow;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class Order {

    public $state;

    public $customer;

    public $picker;

    public $items;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

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

    public function setItems(array $items)
    {
        $this->items = $items;
    }

    public function setCustomer(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function setPicker(Picker $picker)
    {
        $this->picker = $picker;
    }

    public function getName()
    {
        return '#' . $this->id;
    }
}
