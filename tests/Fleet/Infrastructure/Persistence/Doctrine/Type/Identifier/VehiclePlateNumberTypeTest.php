<?php

declare(strict_types=1);

namespace App\Tests\Fleet\Infrastructure\Persistence\Doctrine\Type\Identifier;

use App\Fleet\Domain\ValueObject\VehiclePlateNumber;
use App\Fleet\Infrastructure\Persistence\Doctrine\Type\Identifier\VehiclePlateNumberType;
use App\Shared\CommonUtilities\ReflectionUtils;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use ReflectionException;
use stdClass;

it(
    'converts string to VehiclePlateNumber',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $type = new VehiclePlateNumberType();

        // Act
        $plateNumber = ReflectionUtils::invokeMethod($type, 'fromString', ['ONY1234']);

        // Assert
        expect($plateNumber)->toBeInstanceOf(VehiclePlateNumber::class)
            ->and((string)$plateNumber)->toBe('ONY1234');
    }
);

it(
    'ignores string value',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $type = new VehiclePlateNumberType();

        // Act
        $plateNumber = ReflectionUtils::invokeMethod($type, 'toString', ['ONY1234']);

        // Assert
        expect($plateNumber)->toBeString()
            ->and($plateNumber)->toBe('ONY1234');
    }
);

it(
    'throws exception on invalid identifier type',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $type = new VehiclePlateNumberType();

        // Act // Assert
        expect(
            fn() => ReflectionUtils::invokeMethod($type, 'toString', [new stdClass()])
        )->toThrow(InvalidDataException::class);
    }
);
it(
    'converts VehiclePlateNumber to string',
    /**
     * @throws ReflectionException|InvalidDataException
     */
    function () {
        // Arrange
        $type = new VehiclePlateNumberType();

        // Act
        $plateNumber = ReflectionUtils::invokeMethod(
            $type,
            'toString',
            [VehiclePlateNumber::fromString('ONY1234')]
        );

        // Assert
        expect($plateNumber)->toBeString()
            ->and($plateNumber)->toBe('ONY1234');
    }
);
