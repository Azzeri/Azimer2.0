<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Infrastructure\Repository\Persistence\Doctrine;

use App\EquipmentUsage\Domain\EquipmentUsage;
use App\EquipmentUsage\Domain\Repository\EquipmentUsageRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentUsageRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EquipmentUsageDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentUsageRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return EquipmentUsage::class;
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
