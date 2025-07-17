<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\Equipment\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\Repository\EquipmentRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EquipmentDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return Equipment::class;
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
