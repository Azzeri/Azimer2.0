<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Application\Equipment\Query\Dto;

/**
 * Query model representing equipment property
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentQueryModelProperty
{
    /**
     * @param int $id
     * @param string $templatePropertyDefinitionId
     * @param string $name
     * @param string $type
     * @param bool $isRequired
     * @param string|null $value
     */
    public function __construct(
        public int $id,
        public string $templatePropertyDefinitionId,
        public string $name,
        public string $type,
        public bool $isRequired,
        public ?string $value
    ) {
    }
}
