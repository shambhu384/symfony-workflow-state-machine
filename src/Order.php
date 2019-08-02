<?php

class Order {

    public const STATE_OPEN = 'open';
    public const STATE_CONFIRMED = 'confirmed';
    public const STATE_ASSIGNED_TO_PICKER = 'assigned-to-picker';
    public const STATE_PICKED_UP = 'picked-up';
    public const STATE_DELIVERED = 'delivered';
    public const STATE_ABORTED_BY_CUSTOMER = 'cancelled';
    public const STATE_CANCEKKED_BY_SYSTEM = 'cancelled-by-system';

    public const STATES = [
        self::STATE_OPEN,
        self::STATE_CONFIRMED,
        self::STATE_ASSIGNED_TO_PICKER,
        self::STATE_PICKED_UP,
        self::STATE_DELIVERED,
        self::STATE_ABORTED_BY_CUSTOMER,
        self::STATE_CANCEKKED_BY_SYSTEM
    ];

    public const TRANSITION_UPDATE_ITEM = 'updateItem';

    /**
     * @var string
     */
    private $state = self::STATE_OPEN;
}
