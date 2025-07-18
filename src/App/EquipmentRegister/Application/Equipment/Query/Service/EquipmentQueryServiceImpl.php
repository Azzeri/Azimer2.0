<?php

namespace App\EquipmentRegister\Application\Equipment\Query\Service;

use App\EquipmentRegister\Application\Equipment\Query\Definition\GetEquipment;
use App\EquipmentRegister\Application\Equipment\Query\Definition\SearchEquipments;
use App\EquipmentRegister\Application\Equipment\Query\Dto\EquipmentQueryModel;
use App\EquipmentRegister\Application\Equipment\Query\Repository\EquipmentQueryModelRepository;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\Attribute\QueryHandler;

/**
 * Handlers for equipment queries
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryServiceImpl implements EquipmentQueryService
{
    /**
     * @param EquipmentQueryModelRepository $repository
     */
    public function __construct(private EquipmentQueryModelRepository $repository)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function findOne(GetEquipment $query): ?QueryItem
    {
        $item = $this->repository->findById($query->id);
        return $item !== null
            ? QueryItem::create($query->id->toString(), $item)
            : null;
    }

    /**
     * @inheritDoc
     * @psalm-suppress UnusedParam
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function search(SearchEquipments $query): QueryItemCollection
    {
        $items = $this->repository->search();
        $items = array_map(
            fn(EquipmentQueryModel $equipment) => QueryItem::create(
                $equipment->id,
                $equipment
            ),
            $items
        );
        return QueryItemCollection::create($items);
    }
}
