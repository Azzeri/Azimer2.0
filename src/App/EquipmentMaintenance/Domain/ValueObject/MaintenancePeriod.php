<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\ValueObject;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * An identifier of the equipment being used
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class MaintenancePeriod extends ValueObject
{
    /**
     * @param DateTimeImmutable $actualStartDate
     * @param DateTimeImmutable $actualEndDate
     */
    private function __construct(
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
        private DateTimeImmutable $actualStartDate,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE, nullable: true)]
        private DateTimeImmutable $actualEndDate,
    ) {
    }

    /**
     * Create usage period
     *
     * @param CarbonPeriod $period
     * @return self
     * @throws BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    public static function create(CarbonPeriod $period): self
    {
        $from = CarbonImmutable::instance($period->getStartDate());
        $to = CarbonImmutable::instance($period->getEndDate());

        if (!$period->valid()) {
            throw new BusinessRuleViolationException(message: 'Start date must not be after end date.');
        }

        return new self($from, $to);
    }
}
