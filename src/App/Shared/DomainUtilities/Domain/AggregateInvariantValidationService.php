<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;

/**
 * Service that can be used to validate selected invariant on the selected aggregate
 *
 * @author Mariusz Waloszczyk
 */
interface AggregateInvariantValidationService
{
    /**
     * Validate invariants on the aggregate
     *
     * @param array<int, AggregateInvariant> $invariants
     * @param AggregateRoot $aggregate
     * @return void
     * @throws BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    public function validate(array $invariants, AggregateRoot $aggregate): void;
}
