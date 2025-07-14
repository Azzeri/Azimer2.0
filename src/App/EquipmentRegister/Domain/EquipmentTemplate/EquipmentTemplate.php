<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine\Type\Identifier\EquipmentTemplateIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate representing a single equipment template.
 * Templates specify properties that all inheriting equipment units should have.
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentTemplate extends AggregateRoot
{
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentTemplateIdType::NAME, unique: true)]
        private EquipmentTemplateId $id,
        #[ORM\Embedded(EquipmentTemplateName::class)]
        private EquipmentTemplateName $name,
        #[ORM\ManyToOne(targetEntity: EquipmentCategory::class)]
        #[ORM\JoinColumn(nullable: false)]
        private EquipmentCategory $category,
        #[ORM\ManyToOne(targetEntity: EquipmentManufacturer::class)]
        #[ORM\JoinColumn(nullable: false)]
        private EquipmentManufacturer $manufacturer,
        #[ORM\OneToMany(mappedBy: "template", targetEntity: EquipmentTemplateProperty::class, cascade: ["persist"], orphanRemoval: true)]
        private Collection $properties
    ) {
    }
}
