<?php

declare(strict_types=1);

namespace App\EquipmentRegister\Infrastructure\EquipmentCategory\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\Invariant\Definition\ParentCategoryIsValid;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use ReflectionException;

/**
 * Implementation of {@see ParentCategoryIsValid}
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
final class ParentCategoryIsValidImpl implements ParentCategoryIsValid
{
    /**
     * @inheritDoc
     * @param EquipmentCategory $aggregate
     * @throws ReflectionException
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        $notifications = BusinessRulesNotificationsCollection::create();

        /** @var EquipmentCategory $parentCategory */
        $parentCategory = AggregatePropertyGetter::getProperty($aggregate, 'parentCategory');

        if ($parentCategory->getId()->equals($aggregate->getId())) {
            $message = "Parent category can not be itself";
            $notifications->addNotification(BusinessRuleNotification::fromString($message));
        }

        /** @var EquipmentCategory[] $parentCategory */
        $subcategories = AggregatePropertyGetter::getProperty($aggregate, 'subcategories');
        foreach ($subcategories as $subcategory) {
            if ($subcategory->getId()->equals($aggregate->getId())) {
                $message = "Parent category already assigned as one of subcategories";
                $notifications->addNotification(BusinessRuleNotification::fromString($message));
            }
        }

        return $notifications;
    }
}
