<?php

use App\Fleet\Domain\Enum\FleetPermission;
use Symfony\Component\Uid\Uuid;

dataset('security user with full fleet permissions', [
    [
        [
            'id' => '1',
            'fireBrigadeUnitId' => Uuid::v4()->toString(),
            'permissions' => [
                FleetPermission::ADD_ALL->value,
                FleetPermission::ADD_SUBSERVIENT->value,
                'another'
            ]
        ]
    ]
]);
