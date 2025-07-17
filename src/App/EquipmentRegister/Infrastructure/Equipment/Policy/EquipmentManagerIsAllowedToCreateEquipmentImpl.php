<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\Equipment\Policy;

use App\EquipmentRegister\Domain\Equipment\Policy\EquipmentManagerIsAllowedToCreateEquipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\FireBrigadeUnit\Application\Service\FireBrigadeUnitApiService;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Implementation of {@see EquipmentManagerIsAllowedToCreateEquipment}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManagerIsAllowedToCreateEquipmentImpl implements
    EquipmentManagerIsAllowedToCreateEquipment
{
    /**
     * @param FireBrigadeUnitApiService $fireBrigadeUnitApiService
     */
    public function __construct(private FireBrigadeUnitApiService $fireBrigadeUnitApiService)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        EquipmentManager $manager,
        EquipmentOwnerId $ownerId
    ): BusinessRulesNotificationsCollection {
        $notifications = BusinessRulesNotificationsCollection::create();
        if ($manager->canAddEquipmentToAnyUnit()) {
            return $notifications;
        }

        if ($ownerId->toString() === $manager->getOrganizationalUnitId() && $manager->canAddEquipmentToOwnUnit()) {
            return $notifications;
        }

        $isEquipmentUnitSubservientToManagerUnit = $this->fireBrigadeUnitApiService->isUnitSubservientTo(
            $ownerId->toString(),
            $manager->getOrganizationalUnitId()
        );

        if ($manager->canAddEquipmentToSubservientUnits() && $isEquipmentUnitSubservientToManagerUnit) {
            return $notifications;
        }

        $notifications->addNotification(
            BusinessRuleNotification::fromString(
                "Fleet manager is not authorized to add equipment for the requested unit"
            )
        );
        return $notifications;
    }
}
