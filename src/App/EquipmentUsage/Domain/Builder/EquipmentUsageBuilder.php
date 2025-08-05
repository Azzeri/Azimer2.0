<?php

namespace App\EquipmentUsage\Domain\Builder;

use App\EquipmentUsage\Domain\EquipmentUsage;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageDescription;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageId;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsagePeriod;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsingPersonId;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use Carbon\CarbonPeriod;

/**
 * Builder for {@see EquipmentUsage}
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentUsageBuilder
{
    private EquipmentUsageId $id;
    private EquipmentUsagePeriod $period;
    private UsedEquipmentId $usedEquipmentId;
    private EquipmentUsingPersonId $usingPersonId;
    private ?EquipmentUsageDescription $description;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->id = EquipmentUsageId::generate();
        $this->period = EquipmentUsagePeriod::create(
            CarbonPeriod::create("2025-04-10 11:00:00", "1 day", "2025-04-10 15:00:00")
        );
        $this->usedEquipmentId = UsedEquipmentId::generate();
        $this->usingPersonId = EquipmentUsingPersonId::generate();
        $this->description = null;
    }

    /**
     * @param EquipmentUsageId $id
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withId(EquipmentUsageId $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param EquipmentUsagePeriod $period
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withPeriod(EquipmentUsagePeriod $period): self
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @param UsedEquipmentId $usedEquipmentId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsedEquipmentId(UsedEquipmentId $usedEquipmentId): self
    {
        $this->usedEquipmentId = $usedEquipmentId;
        return $this;
    }

    /**
     * @param EquipmentUsingPersonId $usingPersonId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsingPersonId(EquipmentUsingPersonId $usingPersonId): self
    {
        $this->usingPersonId = $usingPersonId;
        return $this;
    }

    /**
     * @param EquipmentUsageDescription $description
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withDescription(EquipmentUsageDescription $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return EquipmentUsage
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentUsage
    {
        return new EquipmentUsage(
            $this->id,
            $this->period,
            $this->usedEquipmentId,
            $this->usingPersonId,
            $this->description
        );
    }
}
