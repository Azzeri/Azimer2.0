<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type\Identifier;

use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Abstract custom doctrine type for identifiers based on integer primitive
 * TODO - test
 * @author Mariusz Waloszczyk
 */
abstract class AbstractIntegerIdentifierType extends Type
{
    /**
     * Creates a target type from a int value
     *
     * @param int $value
     * @return object
     * @author Mariusz Waloszczyk
     */
    abstract protected function fromInt(int $value): object;

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
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): int
    {
        return $this->toInt($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): object
    {
        return $this->fromInt($value);
    }

    /**
     * Converts a target type to int value
     *
     * @param int $value - sometimes type can be a string anyway
     * @return int
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function toInt(int $value): int
    {
        return $value;
    }
}
