<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Service;

use App\EquipmentRegister\Application\Equipment\Command\CreateEquipment\CreateEquipment;
use App\EquipmentRegister\Application\EquipmentManufacturer\Command\CreateEquipmentManufacturer\CreateEquipmentManufacturer;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\GetEquipmentManufacturer;
use App\EquipmentRegister\Application\EquipmentManufacturer\Query\Definition\SearchEquipmentManufacturers;
use App\EquipmentRegister\Application\EquipmentManufacturer\Service\EquipmentManufacturerApiService;
use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputData;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\Shared\QueryUtilities\Domain\QueryItem;
use App\Shared\QueryUtilities\Domain\QueryItemCollection;
use Ecotone\Modelling\CommandBus;
use Ecotone\Modelling\QueryBus;

/**
 * Implementation of {@see EquipmentApiService}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentApiServiceImpl implements EquipmentApiService
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
//    public function findById(EquipmentManufacturerId $id): ?QueryItem
//    {
//        return $this->queryBus->send(new GetEquipmentManufacturer($id));
//    }
//
//    /**
//     * @inheritDoc
//     * @author Mariusz Waloszczyk
//     */
//    public function search(): QueryItemCollection
//    {
//        return $this->queryBus->send(new SearchEquipmentManufacturers());
//    }
}
