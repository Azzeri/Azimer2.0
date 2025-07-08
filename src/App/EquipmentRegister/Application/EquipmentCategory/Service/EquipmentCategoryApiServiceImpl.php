<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentCategory\Service;

use App\EquipmentRegister\Application\EquipmentCategory\Command\CreateEquipmentCategory\CreateEquipmentCategory;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Definition\GetEquipmentCategory;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Definition\SearchEquipmentCategories;
use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

/**
 * Implementation of {@see EquipmentCategoryApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentCategoryApiServiceImpl implements EquipmentCategoryApiService
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

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function findById(EquipmentCategoryId $categoryId): ?QueryItem
    {
        return $this->queryBus->send(new GetEquipmentCategory($categoryId));
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function search(): QueryItemCollection
    {
        return $this->queryBus->send(new SearchEquipmentCategories());
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function createCategory(EquipmentCategoryInputData $inputData): void
    {
        $this->commandBus->send(new CreateEquipmentCategory($inputData));
    }
}
