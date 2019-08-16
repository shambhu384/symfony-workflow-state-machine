<?php

namespace App;

use Symfony\Component\Workflow\DefinitionBuilder;
use Symfony\Component\Workflow\Workflow;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\MarkingStore\MethodMarkingStore;

class OrderWorkflow {

    public const STATE_OPEN = 'open';
    public const STATE_CONFIRMED = 'confirmed';
    public const STATE_ASSIGNED_TO_PICKER = 'assigned-to-picker';
    public const STATE_DELIVERED = 'delivered';
    public const STATE_CANCELLED = 'cancelled';

    public const TRANSITION_UPDATE_ITEM = 'updateItem';
    public const TRANSITION_ASSIGN_CUSTOMER = 'assignCustomer';
    public const TRANSITION_CONFIRM_ORDER = 'confirmOrder';
    public const TRANSITION_ASSIGN_PICKER = 'assignPicker';
    public const TRANSITION_CONFIRM_DELIVERY = 'confirmDelivery';
    public const TRANSITION_CANCEL_ORDER = 'cancelOrder';

    public static function getWorkflow(): Workflow
    {
        $definitionBuilder = new DefinitionBuilder();

        $definition = $definitionBuilder->addPlaces(['open', 'confirmed', 'assigned-to-picker', 'delivered', 'cancelled'])
            ->addTransition(new Transition(self::TRANSITION_UPDATE_ITEM, self::STATE_OPEN, self::STATE_OPEN))
            ->addTransition(new Transition(self::TRANSITION_ASSIGN_CUSTOMER, self::STATE_OPEN, self::STATE_OPEN))
            ->addTransition(new Transition(self::TRANSITION_CONFIRM_ORDER, self::STATE_OPEN, self::STATE_CONFIRMED))
            ->addTransition(new Transition(self::TRANSITION_ASSIGN_PICKER, self::STATE_CONFIRMED, self::STATE_ASSIGNED_TO_PICKER))
            ->addTransition(new Transition(self::TRANSITION_CONFIRM_DELIVERY, self::STATE_ASSIGNED_TO_PICKER, self::STATE_DELIVERED))
            ->addTransition(new Transition(self::TRANSITION_CANCEL_ORDER, [self::STATE_OPEN, self::STATE_CONFIRMED, self::STATE_ASSIGNED_TO_PICKER], self::STATE_CANCELLED))
            ->build()
        ;
        $making = new MethodMarkingStore(true, 'state');
        return new Workflow($definition, $making);
    }
}
