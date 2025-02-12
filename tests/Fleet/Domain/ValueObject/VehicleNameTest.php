<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Domain\ValueObject;

use App\Fleet\Domain\ValueObject\VehicleName;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

use function Pest\Faker\fake;

it(
    'can not be created if make is too long',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        expect(
            fn() => VehicleName::fromMakeAndModel(fake()->regexify('[A-Za-z0-9]{65}'), 'test')
        )->toThrow(InvalidDataException::class, 'Vehicle make must be between 1 and 64 characters.');
    }
);

it(
    'can not be created if model is too long',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        expect(
            fn() => VehicleName::fromMakeAndModel('test', fake()->regexify('[A-Za-z0-9]{65}'))
        )->toThrow(InvalidDataException::class, 'Vehicle model must be between 1 and 64 characters.');
    }
);
it(
    'returns true if compared to an equal object',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstName = VehicleName::fromMakeAndModel('make', 'model');
        $secondName = VehicleName::fromMakeAndModel('make', 'model');

        // Act // Assert
        expect($firstName->equals($secondName))->toBeTrue();
    }
);

it(
    'returns false if compared to a non-equal object',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstName = VehicleName::fromMakeAndModel('make', 'model');
        $secondName = VehicleName::fromMakeAndModel('maker', 'models');

        // Act // Assert
        expect($firstName->equals($secondName))->toBeFalse();
    }
);
