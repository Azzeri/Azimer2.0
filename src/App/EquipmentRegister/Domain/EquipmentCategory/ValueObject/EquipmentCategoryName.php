<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\ValueObject;

use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentCategoryName extends ValueObject
{
    private function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $name,
    ) {
    }

    public static function fromString(string $name): EquipmentCategoryName
    {
        return new self($name);
    }
}
