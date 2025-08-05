<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\Invariant;

use App\EquipmentUsage\Domain\EquipmentUsage;
use App\Shared\DomainUtilities\Domain\AggregateInvariant;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single invariant for {@see EquipmentUsage}
 * @extends AggregateInvariant<EquipmentUsage>
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(EquipmentUsageInvariant::class)]
interface EquipmentUsageInvariant extends AggregateInvariant
{
}
