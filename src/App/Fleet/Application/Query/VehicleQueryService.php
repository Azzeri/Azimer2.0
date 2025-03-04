<?php

declare(strict_types=1);

namespace App\Fleet\Application\Query;

use App\Fleet\Application\Query\Definition\FindVehicleQuery;
use App\Fleet\Application\Query\Definition\SearchVehiclesQuery;
use App\Fleet\Domain\Dto\VehicleQueryModel;
use App\Fleet\Domain\Repository\VehicleQueryModelRepository;
use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\Attribute\QueryHandler;

/**
 * Handles fleet queries
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleQueryService
{
    /**
     * @param VehicleQueryModelRepository $repository
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        private VehicleQueryModelRepository $repository
    ) {
    }

    /**
     * @param FindVehicleQuery $query
     * @return QueryItem<VehicleQueryModel>|null
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function findOne(FindVehicleQuery $query): ?QueryItem
    {
        $vehicle = $this->repository->findByPlateNumber(VehiclePlateNumber::fromString($query->plateNumber));
        return $vehicle !== null
            ? QueryItem::create($query->plateNumber, $vehicle)
            : null;
    }

    /**
     * @param SearchVehiclesQuery $query
     * @return QueryItemCollection<VehicleQueryModel>
     * @psalm-suppress UnusedParam
     * @author Mariusz Waloszczyk
     */
    #[QueryHandler]
    public function search(SearchVehiclesQuery $query): QueryItemCollection
    {
        $vehicles = $this->repository->search();
        $items = array_map(
            fn(VehicleQueryModel $vehicle) => QueryItem::create(
                $vehicle->plateNumber,
                $vehicle
            ),
            $vehicles->toArray()
        );
        return QueryItemCollection::create($items);
    }
}
