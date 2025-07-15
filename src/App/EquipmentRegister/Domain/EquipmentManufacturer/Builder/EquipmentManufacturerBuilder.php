<?php

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Builder;

use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;

/**
 * Builder for {@see EquipmentManufacturer}
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentManufacturerBuilder
{
    private EquipmentManufacturerId $id;
    private EquipmentManufacturerName $name;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = EquipmentManufacturerId::generate();
        $this->name = EquipmentManufacturerName::fromString('Manufacturer' . uniqid());
    }

    /**
     * @param EquipmentManufacturerId $manufacturerId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentManufacturerId $manufacturerId): self
    {
        $this->id = $manufacturerId;
        return $this;
    }

    /**
     * @param EquipmentManufacturerName $manufacturerName
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withName(EquipmentManufacturerName $manufacturerName): self
    {
        $this->name = $manufacturerName;
        return $this;
    }

    /**
     * @return EquipmentManufacturer
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentManufacturer
    {
        return new EquipmentManufacturer(
            $this->id,
            $this->name
        );
    }
}
