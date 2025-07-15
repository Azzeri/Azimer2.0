<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if equipment manager is allowed to create a new template
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerIsAllowedToCreateTemplate
{
    /**
     * Check if equipment manager is allowed to create a new template
     *
     * @param EquipmentManager $manager
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection;
}
