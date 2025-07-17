<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment;

use App\EquipmentRegister\Domain\Equipment\Entity\EquipmentProperty;
use App\EquipmentRegister\Domain\Equipment\Enum\EquipmentStatus;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\EquipmentRegister\Infrastructure\Equipment\Repository\Persistence\Doctrine\Type\Identifier\EquipmentIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate representing a specific piece of equipment based on a template
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class Equipment extends AggregateRoot
{
    /**
     * @param EquipmentId $id
     * @param EquipmentStatus $status
     * @param EquipmentTemplate $equipmentTemplate
     * @param EquipmentOwnerId $ownerId
     * @param Collection $properties
     */
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentIdType::NAME, unique: true)]
        private EquipmentId $id,
        #[ORM\Column(type: Types::STRING, enumType: EquipmentStatus::class)]
        private EquipmentStatus $status,
        #[ORM\ManyToOne(targetEntity: EquipmentTemplate::class, cascade: ['persist'])]
        private EquipmentTemplate $equipmentTemplate,
        #[ORM\Embedded(class: EquipmentOwnerId::class)]
        private EquipmentOwnerId $ownerId,
        /** @var Collection<int, EquipmentProperty> $properties */
        #[ORM\OneToMany(mappedBy: 'equipment', targetEntity: EquipmentProperty::class, cascade: ['persist', 'remove'])]
        private Collection $properties = new ArrayCollection()
    ) {
    }

    /**
     * @return EquipmentId
     * @author Mariusz Waloszczyk
     */
    public function getId(): EquipmentId
    {
        return $this->id;
    }

    /**
     * @return Collection<int, EquipmentTemplateProperty>
     * @author Mariusz Waloszczyk
     */
    public function getTemplateProperties(): Collection
    {
        return $this->equipmentTemplate->getProperties();
    }

    /**
     * @return Collection<int, EquipmentProperty>
     * @author Mariusz Waloszczyk
     */
    public function getProperties(): Collection
    {
        return $this->properties;
    }

    /**
     * Get equipment property matching the requested template property
     *
     * @param EquipmentTemplateProperty $templateProperty
     * @return EquipmentProperty|null
     * @author Mariusz Waloszczyk
     */
    public function getPropertyForTemplateProperty(EquipmentTemplateProperty $templateProperty): ?EquipmentProperty
    {
        $correspondingProperty = $this->getProperties()->findFirst(
            fn(
                int $index,
                EquipmentProperty $property
            ) => $property->getEquipmentTemplateProperty()->getId() === $templateProperty->getId()
        );

        return $correspondingProperty ?? null;
    }

    /**
     * Assign equipment property value for a template property
     *
     * @param EquipmentTemplatePropertyDefinitionId $propertyId
     * @param EquipmentPropertyValue $value
     * @return void
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function assignPropertyValue(
        EquipmentTemplatePropertyDefinitionId $propertyId,
        EquipmentPropertyValue $value
    ): void {
        $templateProperty = $this->equipmentTemplate->getProperties()->findFirst(
            fn(
                int $key,
                EquipmentTemplateProperty $property
            ) => $property->getDefinition()->getId()->equals($propertyId)
        );

        if (!$templateProperty) {
            throw new ResourceNotFoundException(
                "Relation between property: $propertyId and equipment: $this->id does not exist"
            );
        }

        $property = new EquipmentProperty(
            $value,
            $this,
            $templateProperty
        );
        $this->properties->add($property);
    }
}
