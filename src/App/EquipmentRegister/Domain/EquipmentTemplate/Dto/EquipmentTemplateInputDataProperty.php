<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * A single property for template input data
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateInputDataProperty extends DataTransferObject
{
    /**
     * @param string $id
     * @param bool $isRequired
     */
    public function __construct(
        public string $id,
        public bool $isRequired,
    ) {
    }
}
