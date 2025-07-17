<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifier of organizational unit that owns the equipment
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentOwnerId extends UuidIdentifier
{
}
