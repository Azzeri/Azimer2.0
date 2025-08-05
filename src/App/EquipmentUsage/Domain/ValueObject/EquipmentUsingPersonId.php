<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifier of the person using the equipment
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentUsingPersonId extends UuidIdentifier
{
}
