<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Invariant;

use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\Shared\DomainUtilities\Domain\AggregateInvariant;
use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

/**
 * A single invariant for {@see EquipmentTemplate}
 * @extends AggregateInvariant<EquipmentTemplate>
 *
 * @author Mariusz Waloszczyk
 */
#[AutoconfigureTag(EquipmentTemplateInvariant::class)]
interface EquipmentTemplateInvariant extends AggregateInvariant
{
}
