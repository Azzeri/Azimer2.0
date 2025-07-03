<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * Uuid identifier of every category in the application
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Embeddable]
final readonly class EquipmentCategoryId extends UuidIdentifier
{
}
