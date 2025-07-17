<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\Equipment\Factory\Equipment;

use App\EquipmentRegister\Domain\Equipment\Builder\EquipmentBuilder;
use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputData;
use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\Invariant\EquipmentInvariant;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentTemplate\Repository\EquipmentTemplateRepository;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateId;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\Shared\DomainUtilities\Domain\AggregateInvariantValidationService;
use App\Shared\DomainUtilities\Domain\DataTransferObject;
use App\Shared\DomainUtilities\Domain\StandardAggregateFactory;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see EquipmentFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentFactoryImpl extends StandardAggregateFactory implements EquipmentFactory
{
    /**
     * @param AggregateInvariantValidationService $aggregateInvariantValidationService
     * @param iterable<int, EquipmentInvariant> $invariants
     * @param EquipmentTemplateRepository $templateRepository
     */
    public function __construct(
        protected AggregateInvariantValidationService $aggregateInvariantValidationService,
        #[AutowireIterator(EquipmentInvariant::class)]
        private iterable $invariants,
        private EquipmentTemplateRepository $templateRepository,
    ) {
        parent::__construct($aggregateInvariantValidationService);
    }

    /**
     * @inheritDoc
     * @param EquipmentInputData $inputData
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function inputDataToAggregate(DataTransferObject $inputData): Equipment
    {
        $equipment = (new EquipmentBuilder())
            ->withTemplate($this->templateRepository->findById(EquipmentTemplateId::fromString($inputData->templateId)))
            ->withOwner(EquipmentOwnerId::fromString($inputData->ownerId))
            ->build();

        foreach ($inputData->properties as $property) {
            $equipment->assignPropertyValue(
                EquipmentTemplatePropertyDefinitionId::fromString($property->id),
                $property->value === null
                    ? EquipmentPropertyValue::empty()
                    : EquipmentPropertyValue::fromString($property->value)
            );
        }

        return $equipment;
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
