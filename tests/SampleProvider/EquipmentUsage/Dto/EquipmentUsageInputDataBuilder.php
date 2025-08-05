<?php

namespace Tests\SampleProvider\EquipmentUsage\Dto;

use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentId;
use App\EquipmentUsage\Domain\Dto\EquipmentUsageInputData;
use Symfony\Component\Uid\Uuid;

/**
 * This can be used to create instances of {@see EquipmentUsageInputData} for tests
 *
 * @author Mariusz Waloszczyk
 */
final class EquipmentUsageInputDataBuilder
{
    private string $usedEquipmentId;
    private string $usingPersonId;
    private string $usedFrom;
    private string $usedTo;
    private ?string $description = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usedEquipmentId = EquipmentId::generate()->toString();
        $this->usingPersonId = Uuid::v4()->toString();
        $this->usedFrom = (new \DateTime())->format('Y-m-d H:i:s');
        $this->usedTo = (new \DateTime())->format('Y-m-d H:i:s');
    }

    /**
     * @param string $usedEquipmentId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsedEquipmentId(string $usedEquipmentId): EquipmentUsageInputDataBuilder
    {
        $this->usedEquipmentId = $usedEquipmentId;
        return $this;
    }

    /**
     * @param string $usingPersonId
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsingPersonId(string $usingPersonId): EquipmentUsageInputDataBuilder
    {
        $this->usingPersonId = $usingPersonId;
        return $this;
    }

    /**
     * @param string $usedFrom
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsedFrom(string $usedFrom): EquipmentUsageInputDataBuilder
    {
        $this->usedFrom = $usedFrom;
        return $this;
    }

    /**
     * @param string $usedTo
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withUsedTo(string $usedTo): EquipmentUsageInputDataBuilder
    {
        $this->usedTo = $usedTo;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     * @author Mariusz Waloszczyk
     */
    public function withDescription(string $description): EquipmentUsageInputDataBuilder
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return EquipmentUsageInputData
     * @author Mariusz Waloszczyk
     */
    public function build(): EquipmentUsageInputData
    {
        return new EquipmentUsageInputData(
            $this->usedEquipmentId,
            $this->usingPersonId,
            $this->usedFrom,
            $this->usedTo,
            $this->description
        );
    }
}
