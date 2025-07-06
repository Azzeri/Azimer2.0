<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentCategory\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Repository\EquipmentCategoryRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentCategoryRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EquipmentCategoryDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentCategoryRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return EquipmentCategory::class;
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
