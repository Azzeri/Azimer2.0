<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Repository;

use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\Shared\Domain\Repository\StandardRepository;

/**
 * Repository to retrieve or save equipment template aggregate
 *
 * @extends StandardRepository<EquipmentTemplate>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentTemplateRepository extends StandardRepository
{
}
