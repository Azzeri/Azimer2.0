<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Implementation of {@see EquipmentManagerIsAllowedToCreateCategory}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final readonly class EquipmentManagerIsAllowedToCreateCategoryImpl implements EquipmentManagerIsAllowedToCreateCategory
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection
    {
        if (!$manager->canAddCategory()) {
            return BusinessRulesNotificationsCollection::create([
                BusinessRuleNotification::fromString("Fleet manager is not allowed to add category")
            ]);
        }

        return BusinessRulesNotificationsCollection::create();
    }
}
