<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;

/**
 * Identifier of a fire brigade unit to which a fleet is assigned
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AssignedUnitId extends UuidIdentifier
{
}
