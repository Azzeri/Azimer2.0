<?php

namespace App\Tests\Shared\DomainUtilities\Domain;

use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Symfony\Component\Uid\Uuid;

it(
    'can not be created if UUID is not valid',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange // Act // Assert
        expect(
            fn() => TestUuid::fromString('invalid')
        )->toThrow(InvalidDataException::class, "Invalid UUID: invalid");
    }
);

it(
    'can be created from a valid UUID',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $uuid = Uuid::v4()->toString();

        // Act
        $identifier = TestUuid::fromString($uuid);

        // Assert
        expect($identifier)->toBeInstanceOf(TestUuid::class)
            ->and((string)$identifier)->toEqual($uuid);
    }
);

it(
    'can be converted to string',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $uuid = Uuid::v4()->toString();
        $identifier = TestUuid::fromString($uuid);

        // Act
        $asString = (string)$identifier;

        // Assert
        expect((string)$identifier)->toEqual($asString);
    }
);

it(
    'returns true if compares an equal object',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $uuid = Uuid::v4()->toString();
        $firstIdentifier = TestUuid::fromString($uuid);
        $secondIdentifier = TestUuid::fromString($uuid);

        // Act
        $result = $firstIdentifier->equals($secondIdentifier);

        // Assert
        expect($result)->toBeTrue();
    }
);

it(
    'returns false if compares a non-equal object',
    /**
     * @throws InvalidDataException
     */
    function () {
        // Arrange
        $firstIdentifier = TestUuid::fromString(Uuid::v4()->toString());
        $secondIdentifier = TestUuid::fromString(Uuid::v4()->toString());

        // Act
        $result = $firstIdentifier->equals($secondIdentifier);

        // Assert
        expect($result)->toBeFalse();
    }
);
