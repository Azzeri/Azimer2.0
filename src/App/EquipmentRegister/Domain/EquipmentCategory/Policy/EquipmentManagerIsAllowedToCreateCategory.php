<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Policy checking if equipment manager is allowed to create a new category
 *
 * @author Mariusz Waloszczyk
 */
interface EquipmentManagerIsAllowedToCreateCategory
{
    /**
     * Check if equipment manager is allowed to create a new category
     *
     * @param EquipmentManager $manager
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection;
}
