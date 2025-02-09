<?php

use App\Fleet\Domain\ValueObject\AssignedUnit;
use App\Fleet\Domain\ValueObject\AssignedUnitId;
use Symfony\Component\Uid\Uuid;

dataset('unit', [
    [
        AssignedUnit::create(AssignedUnitId::fromString(Uuid::v4()->toString()))
    ]
]);
