<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * This class represents a basic UUID identifier to be used across domain
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class UuidIdentifier extends IdentifierValueObject
{
    /**
     * @param Uuid $uuid
     */
    final private function __construct(
        #[ORM\Column(type: "uuid")] protected Uuid $uuid
    ) {
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
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return $this->uuid->toString();
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
