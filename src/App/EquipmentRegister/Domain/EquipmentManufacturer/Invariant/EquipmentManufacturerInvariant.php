<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Invariant;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\Shared\DomainUtilities\Domain\AggregateInvariant;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single invariant for {@see EquipmentManufacturer}
 * @extends AggregateInvariant<EquipmentCategory>
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(EquipmentManufacturerInvariant::class)]
interface EquipmentManufacturerInvariant extends AggregateInvariant
{
}
