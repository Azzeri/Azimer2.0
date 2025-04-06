<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Role\Repository\Persistence\Doctrine\Type\Identifier;

use App\Security\Domain\Role\ValueObject\RoleId;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractStringIdentifierType;

/**
 * Custom type for ACL role unique name
 *
 * @author Mariusz Waloszczyk
 */
final class RoleUniqueNameType extends AbstractStringIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'role_unique_name';

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): RoleId
    {
        return RoleId::fromUniqueName($value);
    }


    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return RoleId::class;
    }
}
