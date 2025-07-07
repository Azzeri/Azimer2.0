<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Factory;

use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\Shared\DomainUtilities\Domain\AggregateFactory;

/**
 * Factory for {@see EquipmentManufacturer} aggregate
 * @extends AggregateFactory<EquipmentManufacturer>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManufacturerFactory extends AggregateFactory
{
}
