<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Value object representing a unique name of a template property
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentTemplatePropertyDefinitionName extends ValueObject
{
    /**
     * @param string $name
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING, unique: true)]
        private string $name,
    ) {
    }

    /**
     * @param string $name
     * @return EquipmentTemplatePropertyDefinitionName
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $name): EquipmentTemplatePropertyDefinitionName
    {
        return new self($name);
    }
}
