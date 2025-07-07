<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Shared\ValueObject;

use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\Shared\DomainUtilities\Domain\Actor;

/**
 * Actor that is managing equipment in the application
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManager extends Actor
{
    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddCategory(): bool
    {
        return $this->hasPermission(EquipmentPermission::CATEGORY_ADD->value);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddManufacturer(): bool
    {
        return $this->hasPermission(EquipmentPermission::MANUFACTURER_ADD->value);
    }
}
