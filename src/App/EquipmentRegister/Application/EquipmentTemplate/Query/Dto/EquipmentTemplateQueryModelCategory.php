<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\EquipmentTemplate\Query\Dto;

use App\Shared\DomainUtilities\Domain\DataTransferObject;

/**
 * Query model representing a category assigned to equipment template
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateQueryModelCategory extends DataTransferObject
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
