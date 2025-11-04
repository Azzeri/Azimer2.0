<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use App\Shared\DomainUtilities\Domain\UuidNullableIdentifier;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * An identifier of the person who can perform maintenance
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class PerformedById extends UuidNullableIdentifier
{
}
