<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type\Identifier;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Uid\Uuid;

/**
 * Abstract custom doctrine type for identifiers based on uuid primitive
 *
 * @author Mariusz Waloszczyk
 */
abstract class AbstractUuidIdentifierType extends Type
{
    /**
     * Creates a target type from a string value
     *
     * @param string $value
     * @return object
     * @author Mariusz Waloszczyk
     */
    abstract protected function fromString(string $value): object;

    /**
     * Name of the identifier class
     *
     * @return string
     * @author Mariusz Waloszczyk
     */
    abstract protected function getClassName(): string;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getGuidTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?Uuid
    {
        return $this->toUuid($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): ?object
    {
        return $value === null ? null : $this->fromString($value);
    }

    /**
     * Converts a target type to string value
     *
     * @param object|string|null $value - sometimes type can be a string anyway
     * @return Uuid|null
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function toUuid(object|string|null $value): ?Uuid
    {
        if (is_string($value)) {
            return Uuid::fromString($value);
        } elseif (is_subclass_of($value, UuidIdentifier::class)) {
            return $value->toUuid();
        } elseif (null === $value) {
            return null;
        }

        throw new InvalidDataException("Invalid type provided");
    }
}
