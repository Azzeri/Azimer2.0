<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

/**
 * Implementation of {@see AggregateInvariantValidationService}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final class AggregateInvariantValidationServiceImpl implements AggregateInvariantValidationService
{
    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function validate(array $invariants, AggregateRoot $aggregate): void
    {
        $notifications = [];
        foreach ($invariants as $invariant) {
            $notifications = array_merge($notifications, $invariant->isSatisfiedBy($aggregate)->toArray());
        }
        (BusinessRulesNotificationsCollection::create($notifications))->validate();
    }
}
