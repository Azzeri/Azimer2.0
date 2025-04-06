<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * Identifier of a fire brigade unit
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class FireBrigadeUnitId extends UuidIdentifier
{
}
