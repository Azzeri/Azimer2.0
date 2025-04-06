<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine\Type\Identifier;

use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractStringIdentifierType;

/**
 * Custom type for Tenant email type identifier
 *
 * @author Mariusz Waloszczyk
 */
final class TenantEmailType extends AbstractStringIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'tenant_email';

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): TenantId
    {
        return TenantId::fromEmail($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return TenantId::class;
    }
}
