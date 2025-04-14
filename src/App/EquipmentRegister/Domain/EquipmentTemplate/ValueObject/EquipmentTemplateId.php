<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentTemplateId extends UuidIdentifier
{
}
