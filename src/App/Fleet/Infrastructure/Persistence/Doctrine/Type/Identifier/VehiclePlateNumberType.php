<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Persistence\Doctrine\Type\Identifier;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractStringIdentifierType;

/**
 * Custom type for vehicle plate number identifier
 *
 * @author Mariusz Waloszczyk
 */
final class VehiclePlateNumberType extends AbstractStringIdentifierType
{
    /**
     * @inheritdoc
     */
    public const string NAME = 'vehicle_plate_number';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): VehiclePlateNumber
    {
        return VehiclePlateNumber::fromString($value);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function toString(object|string $value): string
    {
        if (is_string($value)) {
            return $value;
        }

        if (!$value instanceof VehiclePlateNumber) {
            throw new InvalidDataException("Invalid type provided");
        }

        return (string)$value;
    }
}
