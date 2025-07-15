<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Policy;

use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Implementation of {@see EquipmentManagerIsAllowedToCreateTemplate}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManagerIsAllowedToCreateTemplateImpl implements EquipmentManagerIsAllowedToCreateTemplate
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(EquipmentManager $manager): BusinessRulesNotificationsCollection
    {
        if (!$manager->canAddTemplate()) {
            return BusinessRulesNotificationsCollection::create([
                BusinessRuleNotification::fromString("Equipment manager is not allowed to add template")
            ]);
        }

        return BusinessRulesNotificationsCollection::create();
    }
}
