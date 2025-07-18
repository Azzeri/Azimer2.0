<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Query\Dto;

/**
 * Query model representing a manufacturer of equipment query model
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryModelManufacturer
{
    /**
     * @param string $id
     * @param string $name
     */
    public function __construct(
        public string $id,
        public string $name
    ) {
    }
}
