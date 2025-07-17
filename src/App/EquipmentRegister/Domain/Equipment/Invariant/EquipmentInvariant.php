<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Invariant;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\Shared\DomainUtilities\Domain\AggregateInvariant;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single invariant for {@see Equipment}
 * @extends AggregateInvariant<Equipment>
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(EquipmentInvariant::class)]
interface EquipmentInvariant extends AggregateInvariant
{
}
