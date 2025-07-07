<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Implementation of {@see EquipmentManagerIsAllowedToCreateManufacturer}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManagerIsAllowedToCreateManufacturerImpl implements EquipmentManagerIsAllowedToCreateManufacturer
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection
    {
        if (!$manager->canAddManufacturer()) {
            return BusinessRulesNotificationsCollection::create([
                BusinessRuleNotification::fromString("Equipment manager is not allowed to add manufacturer")
            ]);
        }

        return BusinessRulesNotificationsCollection::create();
    }
}
