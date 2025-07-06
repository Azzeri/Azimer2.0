<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Shared\Factory;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\DomainUtilities\Domain\ActorFactory;

/**
 * A factory to create equipment managers
 *
 * @extends ActorFactory<EquipmentManager>
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerFactory extends ActorFactory
{
}
