<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentManufacturerName
{
    private function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
    ) {
    }

    public static function fromString(string $name): EquipmentManufacturerName
    {
        return new self($name);
    }
}
