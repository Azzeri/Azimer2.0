<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Factory;

use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\Shared\DomainUtilities\Domain\AggregateFactory;

/**
 * Factory for {@see EquipmentTemplate} aggregate
 * @extends AggregateFactory<EquipmentTemplate>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentTemplateFactory extends AggregateFactory
{
}
