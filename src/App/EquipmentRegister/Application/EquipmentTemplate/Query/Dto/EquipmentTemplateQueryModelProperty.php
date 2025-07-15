<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Query model representing a property assigned to equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateQueryModelProperty extends DataTransferObject
{
    /**
     * @param string $id
     * @param string $name
     * @param string $type
     * @param bool $isRequired
     */
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
        public bool $isRequired
    ) {
    }
}
