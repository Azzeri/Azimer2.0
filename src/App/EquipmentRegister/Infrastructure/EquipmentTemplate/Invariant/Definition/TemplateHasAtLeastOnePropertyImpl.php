<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\Definition\TemplateNameIsUnique;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\Collection;
use ReflectionException;

/**
 * Implementation of {@see TemplateNameIsUnique}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class TemplateHasAtLeastOnePropertyImpl implements TemplateNameIsUnique
{
    /**
     * @inheritDoc
     * @param EquipmentTemplate $aggregate
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        /** @var Collection<int, EquipmentTemplateProperty> $templateProperties */
        $templateProperties = AggregatePropertyGetter::getProperty($aggregate, 'properties');

        $message = "Template requires at least one property.";
        return !$templateProperties->isEmpty()
            ? BusinessRulesNotificationsCollection::create()
            : BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString($message)]);
    }
}
