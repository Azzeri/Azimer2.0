<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;

/**
 * TODO - I don't like that this class has ID value object, also is this a valid value object,
 * TODO - or does it start to look like an entity
 * A fire brigade unit to which a fleet is assigned
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AssignedUnit extends ValueObject
{
    /**
     * @param AssignedUnitId $id
     * @param array<int,AssignedUnit> $subservientUnits
     * @param AssignedUnit|null $superiorUnit
     */
    private function __construct(
        private AssignedUnitId $id,
        private array $subservientUnits = [],
        private ?AssignedUnit $superiorUnit = null,
    ) {
    }

    /**
     * Create instance of an assigned unit
     *
     * @param AssignedUnitId $id
     * @param array<int,AssignedUnit> $subservientUnits
     * @param AssignedUnit|null $superiorUnit
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(
        AssignedUnitId $id,
        array $subservientUnits = [],
        ?AssignedUnit $superiorUnit = null,
    ): self {
        return new self($id, $subservientUnits, $superiorUnit);
    }

    /**
     * @return AssignedUnitId
     * @author Mariusz Waloszczyk
     */
    public function id(): AssignedUnitId
    {
        return $this->id;
    }

    /**
     * @param AssignedUnitId $unitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isSubservientTo(AssignedUnitId $unitId): bool
    {
        return $this->superiorUnit->id()->equals($unitId);
    }

    /**
     * @param AssignedUnitId $unitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isSuperiorTo(AssignedUnitId $unitId): bool
    {
        $ids = array_map(fn($unit) => $unit->id(), $this->subservientUnits);
        return in_array($unitId, $ids);
    }
}
