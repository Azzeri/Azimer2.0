<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\Factory;

use App\EquipmentUsage\Domain\Builder\EquipmentUsageBuilder;
use App\EquipmentUsage\Domain\Dto\EquipmentUsageInputData;
use App\EquipmentUsage\Domain\EquipmentUsage;
use App\EquipmentUsage\Domain\Invariant\EquipmentUsageInvariant;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageDescription;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsagePeriod;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsingPersonId;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\DomainUtilities\Domain\AggregateInvariantValidationService;
use App\Shared\DomainUtilities\Domain\DataTransferObject;
use App\Shared\DomainUtilities\Domain\StandardAggregateFactory;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Carbon\CarbonPeriod;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see EquipmentUsageFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentUsageFactoryImpl extends StandardAggregateFactory implements
    EquipmentUsageFactory
{
    /**
     * @param AggregateInvariantValidationService $aggregateInvariantValidationService
     * @param iterable<int, EquipmentUsageInvariant> $invariants
     */
    public function __construct(
        protected AggregateInvariantValidationService $aggregateInvariantValidationService,
        #[AutowireIterator(EquipmentUsageInvariant::class)]
        private iterable $invariants,
    ) {
        parent::__construct($aggregateInvariantValidationService);
    }

    /**
     * @inheritDoc
     * @param EquipmentUsageInputData $inputData
     * @throws InvalidDataException|BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    protected function inputDataToAggregate(DataTransferObject $inputData): EquipmentUsage
    {
        $usage = (new EquipmentUsageBuilder())
            ->withUsedEquipmentId(UsedEquipmentId::fromString($inputData->usedEquipmentId))
            ->withUsingPersonId(EquipmentUsingPersonId::fromString($inputData->usingPersonId))
            ->withPeriod(
                EquipmentUsagePeriod::create(
                    CarbonPeriod::create($inputData->usedFrom, '1 day', $inputData->usedTo)
                )
            );

        if ($inputData->description) {
            $usage->withDescription(EquipmentUsageDescription::create($inputData->description));
        }
        return $usage->build();
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getInvariants(): iterable
    {
        return $this->invariants;
    }
}
