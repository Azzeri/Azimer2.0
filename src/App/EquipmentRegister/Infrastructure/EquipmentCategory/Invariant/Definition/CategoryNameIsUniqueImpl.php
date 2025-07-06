<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentCategory\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Invariant\Definition\CategoryNameIsUnique;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

/**
 * Implementation of {@see CategoryNameIsUnique}
 *
 * @author Mariusz Waloszczyk
 */
final class CategoryNameIsUniqueImpl implements CategoryNameIsUnique
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @param EquipmentCategory $aggregate
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        // @TODO - implement with view model repository when ready

        /** @var EquipmentCategoryName $categoryName */
        $categoryName = AggregatePropertyGetter::getProperty($aggregate, 'name');

        $category = $this->entityManager->getRepository(EquipmentCategory::class)
            ->findOneBy(['name.name' => $categoryName]);

        $message = "Category with the given name already exists.";
        return $category === null
            ? BusinessRulesNotificationsCollection::create()
            : BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString($message)]);
    }
}
