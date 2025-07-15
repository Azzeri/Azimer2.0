<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Repository\EquipmentTemplateRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentTemplateRepository}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
final readonly class EquipmentTemplateDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentTemplateRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return EquipmentTemplate::class;
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
