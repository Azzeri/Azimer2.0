<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
// phpcs:ignore Generic.Files.LineLength.TooLong
use App\EquipmentRegister\Infrastructure\EquipmentCategory\Repository\Persistence\Doctrine\Type\Identifier\EquipmentCategoryIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate representing an equipment category
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentCategory extends AggregateRoot
{
    /**
     * @param EquipmentCategoryId $id
     * @param EquipmentCategoryName $name
     * @param Collection $subcategories
     * @param EquipmentCategory|null $parentCategory
     */
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentCategoryIdType::NAME, unique: true)]
        private EquipmentCategoryId $id,
        #[ORM\Embedded(EquipmentCategoryName::class, 'category_')]
        private EquipmentCategoryName $name,
        #[ORM\OneToMany(targetEntity: EquipmentCategory::class, mappedBy: 'parentCategory', cascade: ['persist'])]
        private Collection $subcategories = new ArrayCollection(),
        #[ORM\ManyToOne(targetEntity: EquipmentCategory::class, inversedBy: 'subcategories')]
        private ?EquipmentCategory $parentCategory = null,
    ) {
    }

    /**
     * Return category ID
     *
     * @return EquipmentCategoryId
     * @author Mariusz Waloszczyk
     */
    public function getId(): EquipmentCategoryId
    {
        return $this->id;
    }
}
