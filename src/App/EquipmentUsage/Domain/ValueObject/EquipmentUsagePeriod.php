<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\ValueObject;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\ValueObject;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use DateTimeImmutable;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * A period when the usage took place
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentUsagePeriod extends ValueObject
{
    /**
     * @param DateTimeImmutable $usageFrom
     * @param DateTimeImmutable $usageTo
     */
    private function __construct(
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeImmutable $usageFrom,
        #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
        private DateTimeImmutable $usageTo,
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

        $now = CarbonImmutable::now();
        if ($from->gt($now) || $to->gt($now)) {
            throw new BusinessRuleViolationException(message: 'Usage period cannot be in the future.');
        }

        return new self($from, $to);
    }

    /**
     * @return CarbonImmutable
     * @author Mariusz Waloszczyk
     */
    public function usageFrom(): CarbonImmutable
    {
        return CarbonImmutable::instance($this->usageFrom);
    }

    /**
     * @return CarbonImmutable
     * @author Mariusz Waloszczyk
     */
    public function usageTo(): CarbonImmutable
    {
        return CarbonImmutable::instance($this->usageTo);
    }

    /**
     * @return CarbonPeriod
     * @author Mariusz Waloszczyk
     */
    public function getPeriod(): CarbonPeriod
    {
        return CarbonPeriod::create($this->usageFrom, $this->usageTo);
    }
}
