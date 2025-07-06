<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\ValueObject;

use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateProperty;
use App\Shared\DomainUtilities\Domain\Entity;
use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\ORM\Mapping as ORM;

/**
 *
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
class EquipmentProperty extends Entity// na ewno nie VO?
{
    private function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private int $id,//VO
        #[ORM\ManyToOne(targetEntity: Equipment::class, inversedBy: 'properties')]
        #[ORM\JoinColumn(nullable: false)]
        private Equipment $equipment,
        #[ORM\ManyToOne(targetEntity: EquipmentTemplateProperty::class)]
        private EquipmentTemplateProperty $templateProperty,
        #[ORM\Column(type: 'string')]
        private string $value
    ) {
    }

    public static function create(EquipmentTemplateProperty $templateProperty, string $value, int $nextIdentity, Equipment $equipment): self
    {
        return new self($nextIdentity, $equipment, $templateProperty, $value);
    }
}
