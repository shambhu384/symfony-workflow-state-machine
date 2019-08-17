<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    private $state;

    private $customer;

    private $picker;

    private $items;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId(): ?int
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
