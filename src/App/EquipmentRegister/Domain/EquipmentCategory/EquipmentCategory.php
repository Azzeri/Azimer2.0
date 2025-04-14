<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\EquipmentRegister\Infrastructure\EquipmentCategory\Repository\Persistence\Doctrine\Type\Identifier\EquipmentCategoryIdType;
use App\FireBrigadeUnit\Domain\Repository\FireBrigadeUnitRepository;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Messaging\Attribute\Parameter\Reference;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentCategory extends AggregateRoot
{
    private function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentCategoryIdType::NAME, unique: true)]
        private EquipmentCategoryId $id,

        #[ORM\ManyToOne(targetEntity: EquipmentCategory::class, inversedBy: 'subcategories')]
        private ?EquipmentCategory $parentCategory = null,

        #[ORM\Embedded(EquipmentCategoryName::class)]
        private EquipmentCategoryName $name,

        #[ORM\OneToMany(targetEntity: EquipmentCategory::class, mappedBy: 'parentCategory', cascade: ['persist'])]
        private Collection $subcategories = new ArrayCollection()
    ) {
    }

    public static function create(
        EquipmentCategoryName $name,
        ?EquipmentCategory $parentCategory = null,
    ) {
        return new self(
            EquipmentCategoryId::fromString(Uuid::v4()->toString()),
            $parentCategory,
            $name
        );
    }
}
