<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Command\CreateEquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\Factory\EquipmentCategoryFactory;
use App\EquipmentRegister\Domain\EquipmentCategory\Policy\EquipmentManagerIsAllowedToCreateCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Repository\EquipmentCategoryRepository;
use App\EquipmentRegister\Infrastructure\Shared\Factory\EquipmentManagerFactoryImpl;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Command handler for {@see CreateEquipmentCategory}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final readonly class CreateEquipmentCategoryHandler
{
    /**
     * @param EquipmentCategoryFactory $equipmentCategoryFactory
     * @param EquipmentCategoryRepository $equipmentCategoryRepository
     * @param EquipmentManagerIsAllowedToCreateCategory $equipmentCategoryCanBeAdded
     * @param EquipmentManagerFactoryImpl $equipmentManagerFactory
     */
    public function __construct(
        private EquipmentCategoryFactory $equipmentCategoryFactory,
        private EquipmentCategoryRepository $equipmentCategoryRepository,
        private EquipmentManagerIsAllowedToCreateCategory $equipmentCategoryCanBeAdded,
        private EquipmentManagerFactoryImpl $equipmentManagerFactory
    ) {
    }

    /**
     * @param CreateEquipmentCategory $command
     * @return void
     * @throws BusinessRuleViolationException|ResourceNotFoundException
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    #[CommandHandler]
    public function __invoke(CreateEquipmentCategory $command): void
    {
        $equipmentManager = $this->equipmentManagerFactory->create();
        ($this->equipmentCategoryCanBeAdded->isSatisfiedBy($equipmentManager))
            ->validate();
        $category = $this->equipmentCategoryFactory->fromInputData($command->inputData);
        $this->equipmentCategoryRepository->persist($category);
    }
}
