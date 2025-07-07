<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Command\CreateEquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Factory\EquipmentManufacturerFactory;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Policy\EquipmentManagerIsAllowedToCreateManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Repository\EquipmentManufacturerRepository;
use App\EquipmentRegister\Infrastructure\Shared\Factory\EquipmentManagerFactoryImpl;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Command handler for {@see CreateEquipmentManufacturer}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentManufacturerHandler
{
    /**
     * @param EquipmentManufacturerRepository $repository
     * @param EquipmentManufacturerFactory $factory
     * @param EquipmentManagerFactoryImpl $equipmentManagerFactory
     * @param EquipmentManagerIsAllowedToCreateManufacturer $equipmentManagerIsAllowedToCreateManufacturer
     */
    public function __construct(
        private EquipmentManufacturerRepository $repository,
        private EquipmentManufacturerFactory $factory,
        private EquipmentManagerFactoryImpl $equipmentManagerFactory,
        private EquipmentManagerIsAllowedToCreateManufacturer $equipmentManagerIsAllowedToCreateManufacturer,
    ) {
    }

    /**
     * @param CreateEquipmentManufacturer $command
     * @return void
     * @throws BusinessRuleViolationException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    #[CommandHandler]
    public function __invoke(CreateEquipmentManufacturer $command): void
    {
        $equipmentManager = $this->equipmentManagerFactory->create();
        ($this->equipmentManagerIsAllowedToCreateManufacturer->isSatisfiedBy($equipmentManager))
            ->validateAuthorization();

        $manufacturer = $this->factory->fromInputData($command->inputData);
        $this->repository->persist($manufacturer);
    }
}
