<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateProperty;
use App\EquipmentRegister\Infrastructure\EquipmentTemplate\Repository\Persistence\Doctrine\Type\Identifier\EquipmentTemplateIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 * TODO - pomyslec nad czyms w styulu parent-template
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentTemplate extends AggregateRoot
{
    private function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentTemplateIdType::NAME, unique: true)]
        private EquipmentTemplateId $id,
        #[ORM\Embedded(EquipmentTemplateName::class), ]
        private EquipmentTemplateName $name,
        #[ORM\ManyToOne(targetEntity: EquipmentCategory::class)]
        #[ORM\JoinColumn(nullable: false)]
        private EquipmentCategory $category,
        #[ORM\ManyToOne(targetEntity: EquipmentManufacturer::class)]
        #[ORM\JoinColumn(nullable: false)]
        private EquipmentManufacturer $manufacturer,
        #[ORM\ManyToMany(targetEntity: EquipmentTemplateProperty::class, cascade: ['persist'])]
        private Collection $properties
    ) {
    }

    public static function create(
        EquipmentTemplateName $name,
        EquipmentCategory $category,
        EquipmentManufacturer $manufacturer,
        ArrayCollection $properties
    ): self {
        return new self(
            EquipmentTemplateId::fromString(Uuid::v4()->toString()),
            $name,
            $category,
            $manufacturer,
            $properties
        );
    }
}
