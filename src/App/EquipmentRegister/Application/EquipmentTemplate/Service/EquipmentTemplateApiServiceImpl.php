<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Service;

use App\EquipmentRegister\Application\EquipmentTemplate\Command\CreateEquipmentTemplate\CreateEquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

/**
 * Implementation of {@see EquipmentTemplateApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateApiServiceImpl implements EquipmentTemplateApiService
{
    /**
     * @param CommandBus $commandBus
     * @param QueryBus $queryBus
     */
    public function __construct(
        private CommandBus $commandBus,
        private QueryBus $queryBus,
    ) {
    }

//    /**
//     * @inheritDoc
//     * @author Mariusz Waloszczyk
//     */
//    public function findById(EquipmentTemplateId $id): ?QueryItem
//    {
//        return $this->queryBus->send(new GetEquipmentTemplate($id));
//    }
//
//    /**
//     * @inheritDoc
//     * @author Mariusz Waloszczyk
//     */
//    public function search(): QueryItemCollection
//    {
//        return $this->queryBus->send(new SearchEquipmentTemplates());
//    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function createTemplate(EquipmentTemplateInputData $inputData): void
    {
        $this->commandBus->send(new CreateEquipmentTemplate($inputData));
    }
}
