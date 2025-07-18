<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine;

use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplatePropertyDefinition;
use App\EquipmentRegister\Domain\EquipmentTemplate\Repository\EquipmentTemplatePropertyDefinitionRepository;
use App\Shared\Infrastructure\Doctrine\StandardRepositoryDoctrineImpl;
use Ecotone\Modelling\Attribute\Repository;

/**
 * Doctrine implementation of {@see EquipmentTemplatePropertyDefinition}
 *
 * @author Mariusz Waloszczyk
 */
#[Repository]
// phpcs:ignore Generic.Files.LineLength.TooLong
final readonly class EquipmentTemplatePropertyDefinitionDoctrineRepository extends StandardRepositoryDoctrineImpl implements
    EquipmentTemplatePropertyDefinitionRepository
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getClassName(): string
    {
        return EquipmentTemplatePropertyDefinition::class;
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
