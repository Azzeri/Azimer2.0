<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Represents a single property value for an equipment
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentInputDataProperty extends DataTransferObject
{
    /**
     * @param string $id
     * @param string|null $value
     */
    public function __construct(
        public string $id,
        public ?string $value
    ) {
    }
}
