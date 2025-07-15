<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentTemplate\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\Invariant\Definition\TemplateNameIsUnique;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Implementation of {@see TemplateNameIsUnique}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class TemplateNameIsUniqueImpl implements TemplateNameIsUnique
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        // @TODO - implement with view model repository when ready

        /** @var EquipmentTemplateName $name */
        $name = AggregatePropertyGetter::getProperty($aggregate, 'name');

        $manufacturer = $this->entityManager->getRepository(EquipmentTemplate::class)
            ->findOneBy(['name.name' => $name]);

        $message = "Template with the given name already exists.";
        return $manufacturer === null
            ? BusinessRulesNotificationsCollection::create()
            : BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString($message)]);
    }
}
