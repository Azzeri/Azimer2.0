<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Domain\ValueObject;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

it(
    'can not be created if too short',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        $expectedMessage = "Invalid plate number: X. Plate number must be between 1 and 12 characters and"
            . " contain only letters, numbers, hyphens and spaces.";

        expect(
            fn() => VehiclePlateNumber::fromString('X')
        )->toThrow(InvalidDataException::class, $expectedMessage);
    }
);

it(
    'can not be created if too long',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        $expectedMessage = "Invalid plate number: XXXXXXXXXXXXX. Plate number must be between 1 and 12 characters and"
            . " contain only letters, numbers, hyphens and spaces.";

        expect(
            fn() => VehiclePlateNumber::fromString('XXXXXXXXXXXXX')
        )->toThrow(InvalidDataException::class, $expectedMessage);
    }
);

it(
    'can not be created if contains invalid characters',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        $expectedMessage = "Invalid plate number: ON^&. Plate number must be between 1 and 12 characters and"
            . " contain only letters, numbers, hyphens and spaces.";

        expect(
            fn() => VehiclePlateNumber::fromString('ON^&')
        )->toThrow(InvalidDataException::class, $expectedMessage);
    }
);

it(
    'can be casted to string',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $plateNumber = VehiclePlateNumber::fromString('ONY-1234');

        // Act // Assert
        expect((string)$plateNumber)->toBe('ONY-1234');
    }
);

it(
    'returns true if compared to an equal value',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstPlateNumber = VehiclePlateNumber::fromString('ONY-1234');
        $secondPlateNumber = VehiclePlateNumber::fromString('ONY-1234');

        // Assert
        expect($firstPlateNumber->equals($secondPlateNumber))->toBeTrue();
    }
);

it(
    'returns false if compared to a non-equal value',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstPlateNumber = VehiclePlateNumber::fromString('ONY-1234');
        $secondPlateNumber = VehiclePlateNumber::fromString('OY-1234');

        // Assert
        expect($firstPlateNumber->equals($secondPlateNumber))->toBeFalse();
    }
);
