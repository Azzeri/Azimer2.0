<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier;

use App\Employee\Domain\ValueObject\EmployeeId;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\Infrastructure\Doctrine\Type\Identifier\AbstractUuidIdentifierType;

/**
 * Custom type for employee id
 *
 * @author Mariusz Waloszczyk
 */
final class EmployeeIdType extends AbstractUuidIdentifierType
{
    /**
     * Unique name of the type
     */
    public const string NAME = 'employee_id';

    /**
     * @inheritDoc
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function fromString(string $value): object
    {
        return EmployeeId::fromString($value);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getClassName(): string
    {
        return EmployeeId::class;
    }
}
