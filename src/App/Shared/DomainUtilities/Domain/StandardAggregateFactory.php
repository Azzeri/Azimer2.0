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
    abstract protected function inputDataToAggregate(DataTransferObject $inputData): AggregateRoot;

    /**
     * Specify list of invariants for the aggregate
     *
     * @return iterable<int, AggregateInvariant>
     * @author Mariusz Waloszczyk
     */
    abstract protected function getInvariants(): iterable;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function fromInputData(DataTransferObject $inputData): AggregateRoot
    {
        $aggregate = $this->inputDataToAggregate($inputData);
        $this->invariantValidationService->validate(iterator_to_array($this->getInvariants()), $aggregate);
        return $aggregate;
    }
}
