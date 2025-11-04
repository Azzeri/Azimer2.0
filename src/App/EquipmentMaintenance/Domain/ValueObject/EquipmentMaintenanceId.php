<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifier of a single equipment maintenance
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentMaintenanceId extends UuidIdentifier
{
}
