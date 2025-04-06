<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Fleet\Domain\Enum\FleetPermission;
use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * An employee that will perform operations on fleet
 *
 * @author Mariusz Waloszczyk
 */
final readonly class FleetManager extends ValueObject
{
    /**
     * @param FleetUnitId $assignedUnitId
     * @param array<int, FleetPermission> $permissions
     */
    private function __construct(private FleetUnitId $assignedUnitId, private array $permissions)
    {
    }

    /**
     * Create a new instance of a fleet manager
     *
     * @param $assignedUnitId $assignedUnitId
     * @param array<int, FleetPermission> $permissions
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(FleetUnitId $assignedUnitId, array $permissions): self
    {
        return new self($assignedUnitId, $permissions);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddFleetToAllUnits(): bool
    {
        return in_array(FleetPermission::ADD_ALL, $this->permissions);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddFleetToOwnUnit(): bool
    {
        return in_array(FleetPermission::ADD_OWN, $this->permissions);
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function canAddFleetToSubservientUnits(): bool
    {
        return in_array(FleetPermission::ADD_SUBSERVIENT, $this->permissions);
    }

    /**
     * @return FleetUnitId
     * @author Mariusz Waloszczyk
     */
    public function assignedUnitId(): FleetUnitId
    {
        return $this->assignedUnitId;
    }

    /**
     * @param FleetUnitId $unitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isAssignedToUnit(FleetUnitId $unitId): bool
    {
        return $this->assignedUnitId->equals($unitId);
    }
}
