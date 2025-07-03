<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

/**
 * Common implementation of {@see AggregateFactory} creating an aggregate and checking invariants
 *
 * @template T of AggregateRoot
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class StandardAggregateFactory implements AggregateFactory
{
    /**
     * @param AggregateInvariantValidationService $invariantValidationService
     */
    protected function __construct(protected AggregateInvariantValidationService $invariantValidationService)
    {
    }

    /**
     * Map input data to an aggregate
     *
     * @param DataTransferObject $inputData
     * @return AggregateRoot
     * @author Mariusz Waloszczyk
     */
    protected abstract function inputDataToAggregate(DataTransferObject $inputData): AggregateRoot;

    /**
     * Specify list of invariants for the aggregate
     *
     * @return array<int, AggregateInvariant>
     * @author Mariusz Waloszczyk
     */
    protected abstract function getInvariants(): array;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function fromInputData(DataTransferObject $inputData): AggregateRoot
    {
        $aggregate = $this->inputDataToAggregate($inputData);
        $this->invariantValidationService->validate($this->getInvariants(), $aggregate);
        return $aggregate;
    }
}
