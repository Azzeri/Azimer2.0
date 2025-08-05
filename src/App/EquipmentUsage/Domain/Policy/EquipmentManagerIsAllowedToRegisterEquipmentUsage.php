<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if equipment manager is allowed to record usage for equipment in the requested organizational unit
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerIsAllowedToRegisterEquipmentUsage
{
    /**
     * Check if equipment manager is allowed to record usage for equipment in the requested organizational unit
     *
     * @param EquipmentManager $manager
     * @param UsedEquipmentId $equipmentId
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        EquipmentManager $manager,
        UsedEquipmentId $equipmentId
    ): BusinessRulesNotificationsCollection;
}
