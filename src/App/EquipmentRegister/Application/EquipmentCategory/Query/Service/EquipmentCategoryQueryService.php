<?php

namespace App\EquipmentRegister\Application\EquipmentCategory\Query\Service;

use App\EquipmentRegister\Application\EquipmentCategory\Query\Definition\GetEquipmentCategory;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Definition\SearchEquipmentCategories;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Dto\EquipmentCategoryQueryModel;
use App\EquipmentRegister\Application\EquipmentCategory\Query\Repository\EquipmentCategoryQueryModelRepository;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\Attribute\QueryHandler;

/**
 * Handlers for equipment category queries
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentCategoryQueryService
{
    /**
     * @param EquipmentCategoryQueryModelRepository $equipmentCategoryRepository
     */
    public function __construct(private EquipmentCategoryQueryModelRepository $equipmentCategoryRepository)
    {
    }

    /**
     * @param GetEquipmentCategory $query
     * @return QueryItem<EquipmentCategoryQueryModel>|null
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function findOne(GetEquipmentCategory $query): ?QueryItem
    {
        $category = $this->equipmentCategoryRepository->findById($query->id);
        return $category !== null
            ? QueryItem::create($query->id->toString(), $category)
            : null;
    }

    /**
     * @param SearchEquipmentCategories $query
     * @return QueryItemCollection<EquipmentCategoryQueryModel>
     * @psalm-suppress UnusedParam
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function search(SearchEquipmentCategories $query): QueryItemCollection
    {
        $categories = $this->equipmentCategoryRepository->search();
        $items = array_map(
            fn(EquipmentCategoryQueryModel $category) => QueryItem::create(
                $category->id,
                $category
            ),
            $categories
        );
        return QueryItemCollection::create($items);
    }
}
