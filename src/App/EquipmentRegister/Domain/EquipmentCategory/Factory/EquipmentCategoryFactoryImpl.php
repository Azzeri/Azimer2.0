<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Domain\EquipmentCategory\Factory;

use App\EquipmentRegister\Domain\EquipmentCategory\Dto\EquipmentCategoryInputData;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Invariant\EquipmentCategoryInvariant;
use App\EquipmentRegister\Domain\EquipmentCategory\Repository\EquipmentCategoryRepository;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\Shared\DomainUtilities\Domain\AggregateInvariantValidationService;
use App\Shared\DomainUtilities\Domain\DataTransferObject;
use App\Shared\DomainUtilities\Domain\StandardAggregateFactory;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see EquipmentCategoryFactory}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final readonly class EquipmentCategoryFactoryImpl extends StandardAggregateFactory implements EquipmentCategoryFactory
{
    /**
     * @param AggregateInvariantValidationService $aggregateInvariantValidationService
     * @param EquipmentCategoryRepository $categoryRepository
     * @param array<int, EquipmentCategoryInvariant> $invariants
     */
    public function __construct(
        protected AggregateInvariantValidationService $aggregateInvariantValidationService,
        private EquipmentCategoryRepository $categoryRepository,
        #[AutowireIterator(EquipmentCategoryInvariant::class)]
        private array $invariants,
    ) {
        parent::__construct($aggregateInvariantValidationService);
    }

    /**
     * @inheritDoc
     * @param EquipmentCategoryInputData $inputData
     * @throws ResourceNotFoundException|InvalidDataException
     * @author Mariusz Waloszczyk
     */
    protected function inputDataToAggregate(DataTransferObject $inputData): EquipmentCategory
    {
        $parentCategory = null;
        if ($inputData->parentCategoryId !== null) {
            $parentCategory = $this->categoryRepository->findById(
                EquipmentCategoryId::fromString($inputData->parentCategoryId)
            );
        }

        return new EquipmentCategory(
            EquipmentCategoryId::generate(),
            EquipmentCategoryName::fromString($inputData->name),
            $parentCategory
        );
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    protected function getInvariants(): array
    {
        return $this->invariants;
    }
}
