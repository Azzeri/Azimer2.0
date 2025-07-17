<?php

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Query\Service;

use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\GetEquipmentManufacturer;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\SearchEquipmentManufacturers;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto\EquipmentManufacturerQueryModel;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Repository\EquipmentManufacturerQueryModelRepository;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\Attribute\QueryHandler;

/**
 * Handlers for equipment manufacturer queries
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerQueryServiceImpl implements EquipmentManufacturerQueryService
{
    /**
     * @param EquipmentManufacturerQueryModelRepository $repository
     */
    public function __construct(private EquipmentManufacturerQueryModelRepository $repository)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function findOne(GetEquipmentManufacturer $query): ?QueryItem
    {
        $manufacturer = $this->repository->findById($query->id);
        return $manufacturer !== null
            ? QueryItem::create($query->id->toString(), $manufacturer)
            : null;
    }

    /**
     * @inheritDoc
     * @psalm-suppress UnusedParam
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function search(SearchEquipmentManufacturers $query): QueryItemCollection
    {
        $manufacturers = $this->repository->search();
        $items = array_map(
            fn(EquipmentManufacturerQueryModel $manufacturer) => QueryItem::create(
                $manufacturer->id,
                $manufacturer
            ),
            $manufacturers
        );
        return QueryItemCollection::create($items);
    }
}
