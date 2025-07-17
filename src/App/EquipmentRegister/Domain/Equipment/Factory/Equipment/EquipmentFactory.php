<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Factory\Equipment;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\Shared\DomainUtilities\Domain\AggregateFactory;

/**
 * Factory for {@see Equipment} aggregate
 * @extends AggregateFactory<Equipment>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentFactory extends AggregateFactory
{
}
