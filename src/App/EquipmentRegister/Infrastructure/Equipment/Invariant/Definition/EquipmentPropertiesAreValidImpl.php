<?php

namespace App\EquipmentRegister\Infrastructure\Equipment\Invariant\Definition;

use App\EquipmentRegister\Domain\Equipment\Entity\EquipmentProperty;
use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\Factory\EquipmentPropertyValidationStrategy\EquipmentPropertyValidationStrategyFactory;
use App\EquipmentRegister\Domain\Equipment\Invariant\Definition\EquipmentPropertiesAreValid;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregateRoot;

/**
 * Implementation od {@see EquipmentPropertiesAreValid}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertiesAreValidImpl implements EquipmentPropertiesAreValid
{
    /**
     * @param EquipmentPropertyValidationStrategyFactory $equipmentPropertyValidationStrategyFactory
     */
    public function __construct(
        private EquipmentPropertyValidationStrategyFactory $equipmentPropertyValidationStrategyFactory
    ) {
    }

    /**
     * @inheritDoc
     * @param Equipment $aggregate
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        $notifications = BusinessRulesNotificationsCollection::create();

        foreach ($aggregate->getTemplateProperties() as $templateProperty) {
            $correspondingProperty = $aggregate->getPropertyForTemplateProperty($templateProperty);
            if (!$correspondingProperty) {
                $message = "Property for template property "
                    . "definition: {$templateProperty->getDefinition()->getId()} not found";
                $notifications->addNotification(BusinessRuleNotification::fromString($message));
                continue;
            }

            if ($this->isNullWithoutPermission($correspondingProperty, $templateProperty)) {
                $message = "Property for template property "
                    . "definition: {$templateProperty->getDefinition()->getId()} can not be empty";
                $notifications->addNotification(BusinessRuleNotification::fromString($message));
            }

            if (!$this->isValid($correspondingProperty, $templateProperty)) {
                $message = "Invalid property value: {$correspondingProperty->getValue()} for type: "
                    . "{$templateProperty->getPropertyType()->value}";
                $notifications->addNotification(BusinessRuleNotification::fromString($message));
            }
        }

        if (!$this->isNumberOfPropertiesSameAsNumberOfTemplateProperties($aggregate)) {
            $message = "Invalid number of properties corresponding to template";
            $notifications->addNotification(BusinessRuleNotification::fromString($message));
        }

        return $notifications;
    }

    /**
     * @param EquipmentProperty $property
     * @param EquipmentTemplateProperty $templateProperty
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function isNullWithoutPermission(
        EquipmentProperty $property,
        EquipmentTemplateProperty $templateProperty
    ): bool {
        return $property->getValue()->isEmpty() && $templateProperty->isRequired();
    }

    /**
     * @param EquipmentProperty $property
     * @param EquipmentTemplateProperty $templateProperty
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function isValid(
        EquipmentProperty $property,
        EquipmentTemplateProperty $templateProperty
    ): bool {
        if ($property->getValue()->isEmpty()) {
            return true;
        }

        return $this->equipmentPropertyValidationStrategyFactory->isValid(
            $property->getValue(),
            $templateProperty->getPropertyType()
        );
    }

    /**
     * @param Equipment $equipment
     * @return bool
     * @author Mariusz Waloszczyk
     */
    private function isNumberOfPropertiesSameAsNumberOfTemplateProperties(Equipment $equipment): bool
    {
        return $equipment->getProperties()->count() === $equipment->getTemplateProperties()->count();
    }
}
