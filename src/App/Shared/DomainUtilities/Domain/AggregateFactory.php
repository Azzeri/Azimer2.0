<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;

/**
 * Common factory that can be used to create instances of aggregate
 *
 * @template T of AggregateRoot
 *
 * @author Mariusz Waloszczyk
 */
interface AggregateFactory
{
    /**
     * Create aggregate from DTO
     *
     * @param DataTransferObject $inputData
     * @return T
     *
     * @throws BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    public function fromInputData(DataTransferObject $inputData): AggregateRoot;
}
