<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Policy;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if equipment manager is allowed to create a new equipment in the requested organizational unit
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerIsAllowedToCreateEquipment
{
    /**
     * Check if equipment manager is allowed to create a new equipment in the requested organizational unit
     *
     * @param EquipmentManager $manager
     * @param EquipmentOwnerId $ownerId
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        EquipmentManager $manager,
        EquipmentOwnerId $ownerId
    ): BusinessRulesNotificationsCollection;
}
