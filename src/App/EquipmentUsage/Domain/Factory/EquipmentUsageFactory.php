<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\Factory;

use App\EquipmentUsage\Domain\EquipmentUsage;
use App\Shared\DomainUtilities\Domain\AggregateFactory;

/**
 * Factory for {@see EquipmentUsage} aggregate
 * @extends AggregateFactory<EquipmentUsage>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentUsageFactory extends AggregateFactory
{
}
