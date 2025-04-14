<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentProperty;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateProperty;
use App\EquipmentRegister\Infrastructure\Equipment\Repository\Persistence\Doctrine\Type\Identifier\EquipmentIdType;
use App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Repository\Persistence\Doctrine\Type\Identifier\EquipmentManufacturerIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class Equipment extends AggregateRoot
{
    private function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentIdType::NAME, unique: true)]
        private EquipmentId $id,

        #[ORM\ManyToOne(targetEntity: EquipmentTemplate::class, cascade: ['persist'])]
        private EquipmentTemplate $equipmentTemplate,

        #[ORM\OneToMany(mappedBy: 'equipment', targetEntity: EquipmentProperty::class, cascade: ['persist', 'remove'])]
        private Collection $properties
    ) {
    }

    public static function create(
        EquipmentTemplate $template,
        ArrayCollection $properties = new ArrayCollection()
    ): self {
        return new self(
            EquipmentId::fromString(Uuid::v4()->toString()),
            $template,
            $properties
        );
    }

}
