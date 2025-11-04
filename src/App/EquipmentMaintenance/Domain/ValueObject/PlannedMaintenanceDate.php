<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Planned date of a maintenance
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class PlannedMaintenanceDate extends ValueObject
{
    /**
     * @param DateTimeImmutable $plannedDate
     */
    private function __construct(
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: false)]
        private DateTimeImmutable $plannedDate,
    ) {
    }

    public static function fromDateTime(DateTimeImmutable $plannedDate): self
    {
        return new self($plannedDate);
    }

}
