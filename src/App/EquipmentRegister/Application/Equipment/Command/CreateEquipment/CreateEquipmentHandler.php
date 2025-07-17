<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Command\CreateEquipment;

use App\EquipmentRegister\Domain\Equipment\Factory\Equipment\EquipmentFactory;
use App\EquipmentRegister\Domain\Equipment\Policy\EquipmentManagerIsAllowedToCreateEquipment;
use App\EquipmentRegister\Domain\Equipment\Repository\EquipmentRepository;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Infrastructure\Shared\Factory\EquipmentManagerFactoryImpl;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Command handler for {@see CreateEquipment}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentHandler
{
    /**
     * @param EquipmentRepository $repository
     * @param EquipmentFactory $factory
     * @param EquipmentManagerFactoryImpl $equipmentManagerFactory
     * @param EquipmentManagerIsAllowedToCreateEquipment $equipmentManagerIsAllowedToCreateEquipment
     */
    public function __construct(
        private EquipmentRepository $repository,
        private EquipmentFactory $factory,
        private EquipmentManagerFactoryImpl $equipmentManagerFactory,
        private EquipmentManagerIsAllowedToCreateEquipment $equipmentManagerIsAllowedToCreateEquipment
    ) {
    }

    /**
     * @param CreateEquipment $command
     * @return void
     * @throws BusinessRuleViolationException
     * @throws ResourceNotFoundException
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    #[CommandHandler]
    public function __invoke(CreateEquipment $command): void
    {
        $equipmentManager = $this->equipmentManagerFactory->create();
        $ownerId = EquipmentOwnerId::fromString($command->inputData->ownerId);
        ($this->equipmentManagerIsAllowedToCreateEquipment->isSatisfiedBy($equipmentManager, $ownerId))
            ->validateAuthorization();

        $equipment = $this->factory->fromInputData($command->inputData);
        $this->repository->persist($equipment);
    }
}
