<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type\Identifier;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Abstract custom doctrine type for identifiers based on string primitive
 * TODO - test
 * @author Mariusz Waloszczyk
 */
abstract class AbstractStringIdentifierType extends Type
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
     * Converts a target type to string value
     *
     * @param object|string $value - sometimes type can be a string anyway
     * @return string
     * @author Mariusz Waloszczyk
     */
    abstract protected function toString(object|string $value): string;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $this->toString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): object
    {
        return $this->fromString($value);
    }
}
