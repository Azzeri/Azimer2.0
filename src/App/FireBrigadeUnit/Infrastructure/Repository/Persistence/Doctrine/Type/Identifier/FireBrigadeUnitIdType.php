<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier;

use App\FireBrigadeUnit\Domain\ValueObject\FireBrigadeUnitId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for fire brigade unit id
 *
 * @author Mariusz Waloszczyk
 */
final class FireBrigadeUnitIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'fire_brigade_unit_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return FireBrigadeUnitId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return FireBrigadeUnitId::class;
    }
}
