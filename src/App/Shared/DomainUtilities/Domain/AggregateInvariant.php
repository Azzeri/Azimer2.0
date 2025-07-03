<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * A single invariant verifying if aggregate is valid
 *
 * @template T of AggregateRoot
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
interface AggregateInvariant
{
    /**
     * Check if aggregate satisfies the invariant
     *
     * @param AggregateRoot $aggregate
     * @return BusinessRulesNotificationsCollection
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection;
}
