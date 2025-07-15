<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;

/**
 * Identifier of a single equipment template property
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentTemplatePropertyDefinitionId extends UuidIdentifier
{
}
