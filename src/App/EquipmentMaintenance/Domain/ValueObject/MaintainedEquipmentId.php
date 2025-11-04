<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifier of the equipment being maintained
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class MaintainedEquipmentId extends UuidIdentifier
{
}
