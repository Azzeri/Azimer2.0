<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * A unique name for every category
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentCategoryName extends ValueObject
{
    /**
     * @param string $name
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING, length: 128, unique: true)]
        private string $name,
    ) {
    }

    /**
     * @param string $name
     * @return EquipmentCategoryName
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $name): EquipmentCategoryName
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
