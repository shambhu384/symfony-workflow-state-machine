<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', "1");
ini_set('display_startup_errors', "1");

require __DIR__.'/vendor/autoload.php';

use App\Order;
use App\OrderWorkflow;
use Symfony\Component\Workflow\Workflow;

$order = new Order();
$orderWorkflow =  OrderWorkflow::getWorkflow();

transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_UPDATE_ITEM);

canTransitionToDelivered($orderWorkflow, $order);

transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_CONFIRM_ORDER);

canTransitionToDelivered($orderWorkflow, $order);

transition($orderWorkflow, $order, OrderWorkflow::TRANSITION_ASSIGN_PICKER);

canTransitionToDelivered($orderWorkflow, $order);


function transition(Workflow $orderWorkflow, $order, string $transition) {
    $orderWorkflow->apply($order, $transition);
    echo ('transitioned to:' . $order->getState()). '<br/>';
}

function canTransitionToDelivered(Workflow $orderWorkflow, Order $order): bool
{
    $canTransitionToDelivered = $orderWorkflow->can($order, OrderWorkflow::TRANSITION_CONFIRM_DELIVERY);
    echo ('Can transition to delivered:'), var_dump($canTransitionToDelivered), '<br/>';

    return $canTransitionToDelivered;
}
