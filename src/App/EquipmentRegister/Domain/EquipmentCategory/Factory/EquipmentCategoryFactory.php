<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Factory;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\Shared\DomainUtilities\Domain\AggregateFactory;

/**
 * Factory for {@see EquipmentCategory} aggregate
 * @extends AggregateFactory<EquipmentCategory>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentCategoryFactory extends AggregateFactory
{
}
