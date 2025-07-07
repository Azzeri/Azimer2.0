<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Input data required to create a manufacturer
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerInputData extends DataTransferObject
{
    /**
     * @param string $name
     */
    public function __construct(
        public string $name,
    ) {
    }
}
