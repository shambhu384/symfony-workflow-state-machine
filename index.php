<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");

require __DIR__.'/vendor/autoload.php';

use App\Order;
use App\Product;
use App\Customer;
use App\Picker;
use App\OrderWorkflow;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\EventDispatcher\EventDispatcher;
use App\OrderWorkflowListener;
use Symfony\Component\Workflow\Dumper\StateMachineGraphvizDumper;
use Symfony\Component\Workflow\Dumper\PlantUmlDumper;

$order = new Order('1');

$dispatcher = new EventDispatcher();

$listener = new OrderWorkflowListener();
$dispatcher->addSubscriber($listener);

$orderWorkflow =  OrderWorkflow::getWorkflow($dispatcher);


// Update Items
$items = [];
$items[] = new Product('Banana', '2');
$items[] = new Product('Apple', '1.5');


$transition = transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_UPDATE_ITEM);

if($transition) {
    $order->setItems($items);
}

$transition = transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_UPDATE_ITEM);

if($transition) {
    $order->setCustomer(new Customer('Michelle'));
}


$transition = transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_CONFIRM_ORDER);
$transition = transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_ASSIGN_PICKER);

if ($transition) {
    $order->setPicker(new Picker('Fruity Batman'));
}

function transition(Workflow $orderWorkflow, Order $order, string $transition) {

    if (!$orderWorkflow->can($order, $transition)) {
        return false;
    }

    $orderWorkflow->apply($order, $transition);

    return true;
}


$dumper = new StateMachineGraphvizDumper);
//$dumper = new PlantUmlDumper(PlantUmlDumper::STATEMACHINE_TRANSITION);
$dumper = new PlantUmlDumper(PlantUmlDumper::WORKFLOW_TRANSITION);

echo $dumper->dump(OrderWorkflow::getDefinition());


