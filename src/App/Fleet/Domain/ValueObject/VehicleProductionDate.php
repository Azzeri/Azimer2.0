<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\CommonUtilities\DateTimeUtils;
use App\Shared\DomainUtilities\Domain\ValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Date when the vehicle was manufactured
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class VehicleProductionDate extends ValueObject
{
    /**
     * @param int $year
     * @param int|null $month
     * @throws InvalidDataException
     */
    private function __construct(
        #[ORM\Column(type: Types::INTEGER)]
        private int $year,
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private ?int $month = null
    ) {
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
     * @return int|null
     * @author Mariusz Waloszczyk
     */
    public function month(): ?int
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
        if ($this->month !== null && !DateTimeUtils::isValidMonth($this->month)) {
            throw new InvalidDataException("Invalid month: $this->month");
        }
    }
}
