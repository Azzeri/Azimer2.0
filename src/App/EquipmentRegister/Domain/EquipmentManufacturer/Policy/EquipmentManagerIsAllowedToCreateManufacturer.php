<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if equipment manager is allowed to create a new manufacturer
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerIsAllowedToCreateManufacturer
{
    /**
     * Check if equipment manager is allowed to create a new manufacturer
     *
     * @param EquipmentManager $manager
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection;
}
