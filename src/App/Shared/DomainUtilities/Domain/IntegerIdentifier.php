<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents a basic integer identifier to be used across domain
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class IntegerIdentifier extends IdentifierValueObject
{
    /**
     * @param int $id
     */
    final private function __construct(
        #[ORM\Column(type: Types::INTEGER)] protected int $id
    ) {
    }

    /**
     * @param int $id
     * @return static
     * @author Mariusz Waloszczyk
     */
    public static function fromInt(int $id): static
    {
        return new static($id);
    }

    /**
     * @return int
     * @author Mariusz Waloszczyk
     */
    public function getValue(): int
    {
        return $this->id;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return (string)$this->id;
    }

    /**
     * Verify if ID is equal to the given one
     *
     * @param IntegerIdentifier $other
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function equals(self $other): bool
    {
        return $this->id === $other->getValue();
    }
}
