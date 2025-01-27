<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\CommonUtilities\DateTimeUtils;
use App\Shared\DomainUtilities\Domain\ValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

/**
 * Date when the vehicle was manufactured
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleProductionDate extends ValueObject
{
    /**
     * @param int $year
     * @param int|null $month
     * @throws InvalidDataException
     */
    private function __construct(private int $year, private ?int $month = null)
    {
        $this->validate();
    }

    /**
     * @param int $year
     * @param int|null $month
     * @return self
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fromYearAndMonth(int $year, ?int $month = null): self
    {
        return new self($year, $month);
    }

    /**
     * @return int
     * @author Mariusz Waloszczyk
     */
    public function year(): int
    {
        return $this->year;
    }

    /**
     * @return string|null
     * @author Mariusz Waloszczyk
     */
    public function month(): ?string
    {
        return $this->month;
    }

    /**
     * @param VehicleProductionDate $object
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function equals(VehicleProductionDate $object): bool
    {
        return $this->year === $object->year()
            && $this->month === $object->month();
    }

    /**
     * @return void
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    private function validate(): void
    {
        if (!DateTimeUtils::isValidMonth($this->month)) {
            throw new InvalidDataException("Invalid month: $this->month");
        }
    }
}
