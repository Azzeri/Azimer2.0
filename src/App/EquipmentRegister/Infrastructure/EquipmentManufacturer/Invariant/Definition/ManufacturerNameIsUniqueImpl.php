<?php

namespace App\EquipmentRegister\Infrastructure\EquipmentManufacturer\Invariant\Definition;

use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Invariant\Definition\ManufacturerNameIsUnique;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Implementation of {@see ManufacturerNameIsUnique}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class ManufacturerNameIsUniqueImpl implements ManufacturerNameIsUnique
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

        /** @var EquipmentManufacturerName $manufacturerName */
        $manufacturerName = AggregatePropertyGetter::getProperty($aggregate, 'name');

        $manufacturer = $this->entityManager->getRepository(EquipmentManufacturer::class)
            ->findOneBy(['name.name' => $manufacturerName]);

        $message = "Manufacturer with the given name already exists.";
        return $manufacturer === null
            ? BusinessRulesNotificationsCollection::create()
            : BusinessRulesNotificationsCollection::create([BusinessRuleNotification::fromString($message)]);
    }
}
