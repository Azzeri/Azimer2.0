<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Fleet\Domain\Enum\FleetPermission;
use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * An employee authorized to manage fleet
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManager extends ValueObject
{
    /**
     * @param AssignedUnit $assignedUnit
     * FleetPermission[] $permissions
     */
    private function __construct(private AssignedUnit $assignedUnit, private array $permissions)
    {
    }

    /**
     * Create a new instance of a fleet manager
     *
     * @param AssignedUnit $assignedUnit
     * @param array $permissions
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(AssignedUnit $assignedUnit, array $permissions): self
    {
        return new self($assignedUnit, $permissions);
    }

    /**
     * Check if fleet manager is authorized to manage fleet in the given unit
     *
     * @param AssignedUnit $unit
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canManageFleetInUnit(AssignedUnit $unit): bool
    {
        return $this->canManageFleetInAllUnits()
            || ($this->canManageFleetInOwnUnit() && $this->isAssignedToUnit($unit))
            || ($this->canManageFleetInSubservientUnit() && $unit->isSubservientTo($this->assignedUnit->id()));
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function canManageFleetInAllUnits(): bool
    {
        return in_array(FleetPermission::ADD_ALL, $this->permissions);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function canManageFleetInOwnUnit(): bool
    {
        return in_array(FleetPermission::ADD_OWN, $this->permissions);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function canManageFleetInSubservientUnit(): bool
    {
        return in_array(FleetPermission::ADD_SUBSERVIENT, $this->permissions);
    }

    /**
     * @param AssignedUnit $unit
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function isAssignedToUnit(AssignedUnit $unit): bool
    {
        return $this->assignedUnit
            ->id()
            ->equals($unit->id());
    }
}
