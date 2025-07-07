<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Repository\EquipmentManufacturerRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentManufacturerRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EquipmentManufacturerDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentManufacturerRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return EquipmentManufacturer::class;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getIdentifierPropertyName(): string
    {
        return "id";
    }
}
