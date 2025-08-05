<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Application\Command\RecordEquipmentUsage;

use App\EquipmentRegister\Domain\Shared\Factory\EquipmentManagerFactory;
use App\EquipmentUsage\Domain\Factory\EquipmentUsageFactory;
use App\EquipmentUsage\Domain\Policy\EquipmentManagerIsAllowedToRegisterEquipmentUsage;
use App\EquipmentUsage\Domain\Repository\EquipmentUsageRepository;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Command handler for {@see RecordEquipmentUsage}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class RecordEquipmentUsageHandler
{
    /**
     * @param EquipmentUsageFactory $equipmentUsageFactory
     * @param EquipmentUsageRepository $equipmentUsageRepository
     * @param EquipmentManagerFactory $equipmentManagerFactory
     * @param EquipmentManagerIsAllowedToRegisterEquipmentUsage $equipmentManagerIsAllowedToRegisterEquipmentUsage
     */
    public function __construct(
        private EquipmentUsageFactory $equipmentUsageFactory,
        private EquipmentUsageRepository $equipmentUsageRepository,
        private EquipmentManagerFactory $equipmentManagerFactory,
        private EquipmentManagerIsAllowedToRegisterEquipmentUsage $equipmentManagerIsAllowedToRegisterEquipmentUsage
    ) {
    }

    /**
     * @param RecordEquipmentUsage $command
     * @return void
     * @throws BusinessRuleViolationException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    #[CommandHandler]
    public function __invoke(RecordEquipmentUsage $command): void
    {
        $equipmentManager = $this->equipmentManagerFactory->create();
        ($this->equipmentManagerIsAllowedToRegisterEquipmentUsage->isSatisfiedBy(
            $equipmentManager,
            UsedEquipmentId::fromString($command->inputData->usedEquipmentId)
        ))->validateAuthorization();

        $usage = $this->equipmentUsageFactory->fromInputData($command->inputData);
        $this->equipmentUsageRepository->persist($usage);
    }
}
