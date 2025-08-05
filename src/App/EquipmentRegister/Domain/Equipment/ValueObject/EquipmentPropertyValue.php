<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * A specific value for equipment property in a form of string
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentPropertyValue extends ValueObject
{
    /**
     * @param string|null $value
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING, length: 128, nullable: true)]
        private ?string $value,
    ) {
    }

    /**
     * @param string $value
     * @return EquipmentPropertyValue
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $value): EquipmentPropertyValue
    {
        return new self($value);
    }

    /**
     * @return EquipmentPropertyValue
     * @author Mariusz Waloszczyk
     */
    public static function empty(): EquipmentPropertyValue
    {
        return new self(null);
    }

    /**
     * @return string|null
     * @author Mariusz Waloszczyk
     */
    public function getValue(): ?string
    {
        return $this->value;
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isEmpty(): bool
    {
        return $this->value === null;
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return $this->value;
    }
}
