<?php

declare(strict_types=1);

namespace App\Employee\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * Identifier of a fire brigade unit that employee belongs to
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EmployeeUnitId extends UuidIdentifier
{
}
