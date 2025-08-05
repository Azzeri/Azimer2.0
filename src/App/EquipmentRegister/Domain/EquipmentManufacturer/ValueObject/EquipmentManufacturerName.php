<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Value object for equipment manufacturer name
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentManufacturerName
{
    /**
     * @param string $name
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
    ) {
    }

    /**
     * @param string $name
     * @return EquipmentManufacturerName
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $name): EquipmentManufacturerName
    {
        return new self($name);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return $this->name;
    }
}
