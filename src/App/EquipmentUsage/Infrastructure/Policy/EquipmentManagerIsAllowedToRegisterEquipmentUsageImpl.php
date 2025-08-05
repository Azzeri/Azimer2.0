<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Infrastructure\Policy;

use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModel;
use App\EquipmentRegister\Application\Equipment\Query\Repository\EquipmentQueryModelRepository;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\EquipmentRegister\Domain\Shared\ValueObject\EquipmentManager;
use App\EquipmentUsage\Domain\Policy\EquipmentManagerIsAllowedToRegisterEquipmentUsage;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\FireBrigadeUnit\Application\Service\FireBrigadeUnitApiService;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Implementation of {@see EquipmentManagerIsAllowedToRegisterEquipmentUsage}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManagerIsAllowedToRegisterEquipmentUsageImpl implements
    EquipmentManagerIsAllowedToRegisterEquipmentUsage
{
    /**
     * @param FireBrigadeUnitApiService $fireBrigadeUnitApiService
     * @param EquipmentQueryModelRepository $equipmentQueryRepository
     */
    public function __construct(
        private FireBrigadeUnitApiService $fireBrigadeUnitApiService,
        private EquipmentQueryModelRepository $equipmentQueryRepository,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        EquipmentManager $manager,
        UsedEquipmentId $equipmentId
    ): BusinessRulesNotificationsCollection {
        $notifications = BusinessRulesNotificationsCollection::create();
        if ($manager->canRegisterEquipmentUsageForAnyUnit()) {
            return $notifications;
        }

        $equipment = $this->equipmentQueryRepository->findById(EquipmentId::fromString($equipmentId->toString()));
        if ($equipment === null) {
            throw new ResourceNotFoundException("Equipment with id {$equipmentId->toString()} not found");
        }

        if ($this->satisfiedForOwnUnit($equipment, $manager)) {
            return $notifications;
        }

        if ($this->satisfiedForSubservientUnits($equipment, $manager)) {
            return $notifications;
        }

        $notifications->addNotification(
            BusinessRuleNotification::fromString(
                "Equipment manager is not authorized to register usage for the requested equipment"
            )
        );
        return $notifications;
    }

    /**
     * @param EquipmentQueryModel $equipmentQueryModel
     * @param EquipmentManager $manager
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function satisfiedForOwnUnit(EquipmentQueryModel $equipmentQueryModel, EquipmentManager $manager): bool
    {
        $isOwnUnit = $equipmentQueryModel->owner === $manager->getOrganizationalUnitId();
        return $isOwnUnit && $manager->canRegisterEquipmentUsageForOwnUnit();
    }

    /**
     * @param EquipmentQueryModel $equipmentQueryModel
     * @param EquipmentManager $manager
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function satisfiedForSubservientUnits(
        EquipmentQueryModel $equipmentQueryModel,
        EquipmentManager $manager
    ): bool {
        $isEquipmentUnitSubservientToManagerUnit = $this->fireBrigadeUnitApiService->isUnitSubservientTo(
            $equipmentQueryModel->owner,
            $manager->getOrganizationalUnitId()
        );
        return $manager->canRegisterEquipmentUsageForSubservientUnits() && $isEquipmentUnitSubservientToManagerUnit;
    }
}
