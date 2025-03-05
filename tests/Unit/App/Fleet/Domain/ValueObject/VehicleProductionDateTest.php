<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Domain\ValueObject;

use App\Fleet\Domain\ValueObject\VehicleProductionDate;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

it(
    'can not be created with an invalid month',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        expect(
            fn() => VehicleProductionDate::fromYearAndMonth(2024, 9999)
        )->toThrow(InvalidDataException::class, "Invalid month: 9999");
    }
);

it(
    'can be created from year and month',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        expect(VehicleProductionDate::fromYearAndMonth(2024, 11))
            ->toBeInstanceOf(VehicleProductionDate::class);
    }
);

it(
    'returns true if compared production dates equal',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstDate = VehicleProductionDate::fromYearAndMonth(2024, 11);
        $secondDate = VehicleProductionDate::fromYearAndMonth(2024, 11);

        // Act // Assert
        expect($firstDate->equals($secondDate))->toBeTrue();
    }
);

it(
    'returns false if compared production dates are different',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstDate = VehicleProductionDate::fromYearAndMonth(2024, 11);
        $secondDate = VehicleProductionDate::fromYearAndMonth(2024, 10);

        // Act // Assert
        expect($firstDate->equals($secondDate))->toBeFalse();
    }
);
