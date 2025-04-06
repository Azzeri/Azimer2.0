<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Resource\Repository\Persistence\Doctrine\Type\Identifier;

use App\Security\Domain\Resource\ValueObject\ResourceId;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractStringIdentifierType;

/**
 * Custom type for ACL resource unique name
 *
 * @author Mariusz Waloszczyk
 */
final class ResourceUniqueNameType extends AbstractStringIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'resource_unique_name';

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): ResourceId
    {
        return ResourceId::fromUniqueName($value);
    }


    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return ResourceId::class;
    }
}
