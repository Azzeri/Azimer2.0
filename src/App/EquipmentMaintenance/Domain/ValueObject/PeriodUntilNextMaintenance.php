<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Period until the next planned maintenance
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class PeriodUntilNextMaintenance extends ValueObject
{
    /**
     * @param int $days
     */
    private function __construct(
        #[ORM\Column(type: Types::INTEGER, nullable: true)]
        private int $days
    ) {
    }

    public static function fromDays(int $days): self
    {
        return new self($days);
    }
}
