<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentManufacturer\Factory;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Invariant\EquipmentManufacturerInvariant;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\Shared\DomainUtilities\Domain\AggregateInvariantValidationService;
use App\Shared\DomainUtilities\Domain\DataTransferObject;
use App\Shared\DomainUtilities\Domain\StandardAggregateFactory;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see EquipmentManufacturerFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentManufacturerFactoryImpl extends StandardAggregateFactory implements
    EquipmentManufacturerFactory
{
    /**
     * @param AggregateInvariantValidationService $aggregateInvariantValidationService
     * @param iterable<int, EquipmentManufacturerInvariant> $invariants
     */
    public function __construct(
        protected AggregateInvariantValidationService $aggregateInvariantValidationService,
        #[AutowireIterator(EquipmentManufacturerInvariant::class)]
        private iterable $invariants,
    ) {
        parent::__construct($aggregateInvariantValidationService);
    }

    /**
     * @inheritDoc
     * @param EquipmentManufacturerInputData $inputData
     * @author Mariusz Waloszczyk
     */
    protected function inputDataToAggregate(DataTransferObject $inputData): EquipmentManufacturer
    {
        $manufacturer = (new EquipmentManufacturerBuilder())
            ->withName(EquipmentManufacturerName::fromString($inputData->name));

        return $manufacturer->build();
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
