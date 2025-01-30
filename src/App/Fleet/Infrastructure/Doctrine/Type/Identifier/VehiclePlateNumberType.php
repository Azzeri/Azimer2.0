<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Doctrine\Type\Identifier;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractStringIdentifierType;

/**
 * Custom type for vehicle plate number identifier
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
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
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    protected function fromString(string $value): VehiclePlateNumber
    {
        return VehiclePlateNumber::fromString($value);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    protected function toString(object $value): string
    {
        if (!$value instanceof VehiclePlateNumber) {
            throw new InvalidDataException("Invalid type provided");
        }

        return (string)$value;
    }
}
