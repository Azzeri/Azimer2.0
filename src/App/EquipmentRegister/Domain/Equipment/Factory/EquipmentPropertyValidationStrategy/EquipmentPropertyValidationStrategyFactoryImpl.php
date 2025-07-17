<?php

namespace App\EquipmentRegister\Domain\Equipment\Factory\EquipmentPropertyValidationStrategy;

use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationDateStrategy;
use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationDateTimeStrategy;
use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationFloatStrategy;
use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationIntegerStrategy;
use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationTextStrategy;
use App\EquipmentRegister\Domain\Equipment\Strategy\Definition\EquipmentPropertyValidationYesNoStrategy;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;

/**
 * Implementation of {@see EquipmentPropertyValidationStrategyFactory}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EquipmentPropertyValidationStrategyFactoryImpl implements
    EquipmentPropertyValidationStrategyFactory
{
    /**
     * @param EquipmentPropertyValidationYesNoStrategy $yesNoStrategy
     * @param EquipmentPropertyValidationDateStrategy $dateStrategy
     * @param EquipmentPropertyValidationDateTimeStrategy $dateTimeStrategy
     * @param EquipmentPropertyValidationTextStrategy $textStrategy
     * @param EquipmentPropertyValidationFloatStrategy $floatStrategy
     * @param EquipmentPropertyValidationIntegerStrategy $integerStrategy
     */
    public function __construct(
        private EquipmentPropertyValidationYesNoStrategy $yesNoStrategy,
        private EquipmentPropertyValidationDateStrategy $dateStrategy,
        private EquipmentPropertyValidationDateTimeStrategy $dateTimeStrategy,
        private EquipmentPropertyValidationTextStrategy $textStrategy,
        private EquipmentPropertyValidationFloatStrategy $floatStrategy,
        private EquipmentPropertyValidationIntegerStrategy $integerStrategy
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isValid(
        EquipmentPropertyValue $propertyValue,
        EquipmentTemplatePropertyDefinitionType $definitionType
    ): bool {
        $strategy = match ($definitionType) {
            EquipmentTemplatePropertyDefinitionType::YES_NO => $this->yesNoStrategy,
            EquipmentTemplatePropertyDefinitionType::DATE => $this->dateStrategy,
            EquipmentTemplatePropertyDefinitionType::DATE_TIME => $this->dateTimeStrategy,
            EquipmentTemplatePropertyDefinitionType::TEXT => $this->textStrategy,
            EquipmentTemplatePropertyDefinitionType::INTEGER => $this->integerStrategy,
            EquipmentTemplatePropertyDefinitionType::DECIMAL => $this->floatStrategy,
        };

        return $strategy->isValid($propertyValue);
    }
}
