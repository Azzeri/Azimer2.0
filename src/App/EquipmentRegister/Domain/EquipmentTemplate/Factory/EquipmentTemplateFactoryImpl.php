<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentTemplate\Factory;

use App\EquipmentRegister\Domain\EquipmentCategory\Repository\EquipmentCategoryRepository;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Repository\EquipmentManufacturerRepository;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerId;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputData;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\EquipmentTemplateInvariant;
use App\EquipmentRegister\Domain\EquipmentTemplate\Repository\EquipmentTemplatePropertyDefinitionRepository;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionId;
use App\Shared\DomainUtilities\Domain\AggregateInvariantValidationService;
use App\Shared\DomainUtilities\Domain\DataTransferObject;
use App\Shared\DomainUtilities\Domain\StandardAggregateFactory;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see EquipmentTemplateFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentTemplateFactoryImpl extends StandardAggregateFactory implements
    EquipmentTemplateFactory
{
    /**
     * @param AggregateInvariantValidationService $aggregateInvariantValidationService
     * @param iterable<int, EquipmentTemplateInvariant> $invariants
     * @param EquipmentCategoryRepository $equipmentCategoryRepository
     * @param EquipmentManufacturerRepository $equipmentManufacturerRepository
     * @param EquipmentTemplatePropertyDefinitionRepository $propertyDefinitionRepository
     */
    public function __construct(
        protected AggregateInvariantValidationService $aggregateInvariantValidationService,
        #[AutowireIterator(EquipmentTemplateInvariant::class)]
        private iterable $invariants,
        private EquipmentCategoryRepository $equipmentCategoryRepository,
        private EquipmentManufacturerRepository $equipmentManufacturerRepository,
        private EquipmentTemplatePropertyDefinitionRepository $propertyDefinitionRepository
    ) {
        parent::__construct($aggregateInvariantValidationService);
    }

    /**
     * @inheritDoc
     * @param EquipmentTemplateInputData $inputData
     * @return EquipmentTemplate
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function inputDataToAggregate(DataTransferObject $inputData): EquipmentTemplate
    {
        $category = $this->equipmentCategoryRepository->findById(
            EquipmentCategoryId::fromString($inputData->categoryId)
        );
        $manufacturer = $this->equipmentManufacturerRepository->findById(
            EquipmentManufacturerId::fromString($inputData->manufacturerId)
        );

        $template = (new EquipmentTemplateBuilder())
            ->withName(EquipmentTemplateName::fromString($inputData->name))
            ->withCategory($category)
            ->withManufacturer($manufacturer)
            ->build();

        foreach ($inputData->properties as $property) {
            $definition = $this->propertyDefinitionRepository->findById(
                EquipmentTemplatePropertyDefinitionId::fromString($property->id),
            );
            $template->assignProperty($definition, $property->isRequired);
        }

        return $template;
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
