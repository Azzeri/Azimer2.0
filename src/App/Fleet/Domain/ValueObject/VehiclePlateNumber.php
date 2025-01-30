<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\CommonUtilities\StringUtils;
use App\Shared\DomainUtilities\Domain\IdentifierValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

/**
 * Vehicle plate number, which is also vehicle's unique identifier
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehiclePlateNumber extends IdentifierValueObject
{
    public const int MIN_LENGTH = 2;
    public const int MAX_LENGTH = 12;

    /**
     * @param string $plateNumber
     * @throws InvalidDataException
     */
    private function __construct(private string $plateNumber)
    {
        $this->validate();
    }

    /**
     * Create a new plate number instance
     *
     * @param string $plateNumber
     * @return self
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $plateNumber): self
    {
        return new self($plateNumber);
    }

    /**
     * @param VehiclePlateNumber $object
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function equals(VehiclePlateNumber $object): bool
    {
        return (string)$object === (string)$this;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return $this->plateNumber;
    }

    /**
     * @return void
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    private function validate(): void
    {
        $isValid = StringUtils::isLengthBetween($this->plateNumber, self::MIN_LENGTH, self::MAX_LENGTH)
            && !StringUtils::containsSpecialCharacters($this->plateNumber, ['-', ' ']);

        if (!$isValid) {
            $message = "Invalid plate number: $this->plateNumber. Plate number must be between 1 and 12 characters and"
                . " contain only letters, numbers, hyphens and spaces.";
            throw new InvalidDataException($message);
        }
    }
}
