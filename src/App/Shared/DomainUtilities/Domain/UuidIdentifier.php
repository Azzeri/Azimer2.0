<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Symfony\Component\Uid\Uuid;

/**
 * This class represents a basic UUID identifier to be used across domain
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class UuidIdentifier extends ValueObject
{
    /**
     * @param Uuid $uuid
     */
    protected function __construct(private Uuid $uuid)
    {
    }

    /**
     * Create a new UUID from a string
     *
     * @param string $uuid
     * @return static
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $uuid): static
    {
        if (!Uuid::isValid($uuid)) {
            throw new InvalidDataException("Invalid UUID: {$uuid}");
        }

        return new static(Uuid::fromString($uuid));
    }

    /**
     * Return UUID in the form of string
     *
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function toString(): string
    {
        return $this->uuid->toRfc4122();
    }

    /**
     * Verify if UUID is equal to the given one
     *
     * @param UuidIdentifier $other
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function equals(self $other): bool
    {
        return $this->uuid->equals($other->uuid);
    }
}
