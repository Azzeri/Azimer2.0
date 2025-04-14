<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject;

use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyType;
use App\Shared\DomainUtilities\Domain\Entity;
use App\Shared\DomainUtilities\Domain\ValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\ORM\Mapping as ORM;

/**
 * //TODO - jakies predefiniowane propertiesy z logiką biznesową
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
abstract class EquipmentTemplateProperty extends Entity
{
    protected function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column]
        private int $id,//VO

        #[ORM\Column(enumType: EquipmentTemplatePropertyType::class)]
        private EquipmentTemplatePropertyType $propertyType,

        #[ORM\Column(type: 'string')]
        private string $name,//VO
    )
    {
    }


//    public static function create(EquipmentTemplatePropertyType $type, string $name, int $nextIdentity): self
//    {
//        return new self(
//            $nextIdentity,
//            propertyType: $type,
//            name: $name
//        );
//    }
}
