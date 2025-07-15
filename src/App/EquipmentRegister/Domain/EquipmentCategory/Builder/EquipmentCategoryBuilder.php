<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Builder;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class can be used to create {@see EquipmentCategory} with the requested parameters
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentCategoryBuilder
{
    private EquipmentCategoryId $id;
    private EquipmentCategoryName $name;
    private ?EquipmentCategory $parent = null;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = EquipmentCategoryId::generate();
        $this->name = EquipmentCategoryName::fromString('Helmet' . uniqid());
    }

    /**
     * @param EquipmentCategoryId $id
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentCategoryId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param EquipmentCategoryName $name
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withName(EquipmentCategoryName $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param EquipmentCategory $parent
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withParent(EquipmentCategory $parent): self
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return EquipmentCategory
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentCategory
    {
        return new EquipmentCategory(
            $this->id,
            $this->name,
            new ArrayCollection(),
            $this->parent
        );
    }
}
