<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Command\CreateEquipmentTemplate;

use App\EquipmentRegister\Domain\EquipmentTemplate\Factory\EquipmentTemplateFactory;
use App\EquipmentRegister\Domain\EquipmentTemplate\Policy\EquipmentManagerIsAllowedToCreateTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Repository\EquipmentTemplateRepository;
use App\EquipmentRegister\Domain\Shared\Factory\EquipmentManagerFactory;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use Ecotone\Modelling\Attribute\CommandHandler;

/**
 * Command handler for {@see CreateEquipmentTemplate}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class CreateEquipmentTemplateHandler
{
    /**
     * @param EquipmentTemplateRepository $repository
     * @param EquipmentTemplateFactory $factory
     * @param EquipmentManagerFactory $equipmentManagerFactory
     * @param EquipmentManagerIsAllowedToCreateTemplate $equipmentManagerIsAllowedToCreateTemplate
     */
    public function __construct(
        private EquipmentTemplateRepository $repository,
        private EquipmentTemplateFactory $factory,
        private EquipmentManagerFactory $equipmentManagerFactory,
        private EquipmentManagerIsAllowedToCreateTemplate $equipmentManagerIsAllowedToCreateTemplate,
    ) {
    }

    /**
     * @param CreateEquipmentTemplate $command
     * @return void
     * @throws BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    #[CommandHandler]
    public function __invoke(CreateEquipmentTemplate $command): void
    {
        $equipmentManager = $this->equipmentManagerFactory->create();
        ($this->equipmentManagerIsAllowedToCreateTemplate->isSatisfiedBy($equipmentManager))
            ->validateAuthorization();

        $template = $this->factory->fromInputData($command->inputData);
        $this->repository->persist($template);
    }
}
