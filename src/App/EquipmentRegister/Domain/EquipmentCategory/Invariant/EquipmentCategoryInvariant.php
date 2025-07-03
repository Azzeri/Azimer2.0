<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Invariant;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\Shared\DomainUtilities\Domain\AggregateInvariant;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single invariant for {@see EquipmentCategory}
 * @extends AggregateInvariant<EquipmentCategory>
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(EquipmentCategoryInvariant::class)]
interface EquipmentCategoryInvariant extends AggregateInvariant
{
}
