<?php

namespace App;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\LeaveEvent;

class OrderWorkflowListener implements EventSubscriberInterface
{
    public function onLeave(LeaveEvent $event)
    {
        echo sprintf(
            'Order (id: "%s") perfomed transition "%s" from "%s" to "%s"',
            $event->getSubject()->getId(),
            $event->getSubject()->getName(),
            implode(', ', array_keys($event->getMarking()->getPlaces())),
            implode(', ', $event->getTransition()->getTos())
        );

        echo '<br/>';
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.order.leave' => 'onLeave'
        ];
    }

}
