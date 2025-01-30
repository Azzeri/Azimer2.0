<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Type\Identifier;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

/**
 * Abstract custom doctrine type for identifiers based on string primitive
 *
 * @author Mariusz Waloszczyk
 */
abstract class AbstractStringIdentifierType extends Type
{
    /**
     * Unique name of the property, you need to overload this
     */
    public const string NAME = '';

    /**
     * Creates a target type from a string value
     *
     * @param string $value
     * @return object
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    abstract protected function fromString(string $value): object;

    /**
     * Converts a target type to string value
     *
     * @param object $value
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    abstract protected function toString(object $value): string;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return $platform->getStringTypeDeclarationSQL($column);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        return $this->toString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function convertToPHPValue($value, AbstractPlatform $platform): object
    {
        return $this->fromString($value);
    }
}

