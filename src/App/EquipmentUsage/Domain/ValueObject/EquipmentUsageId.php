<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * A unique equipment usage identifier
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentUsageId extends UuidIdentifier
{
}
