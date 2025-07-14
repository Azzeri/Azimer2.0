<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentManufacturer\Query\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Query model representing an equipment manufacturer
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerQueryModel extends DataTransferObject
{
    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
