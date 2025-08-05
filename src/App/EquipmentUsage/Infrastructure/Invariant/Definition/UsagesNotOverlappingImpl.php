<?php

namespace App\EquipmentUsage\Infrastructure\Invariant\Definition;

use App\EquipmentUsage\Domain\EquipmentUsage;
use App\EquipmentUsage\Domain\Invariant\Definition\UsagesNotOverlapping;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Carbon\CarbonPeriod;
use Doctrine\ORM\EntityManagerInterface;
use ReflectionException;

/**
 * Implementation of {@see UsagesNotOverlapping}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class UsagesNotOverlappingImpl implements UsagesNotOverlapping
{
    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @param EquipmentUsage $aggregate
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(AggregateRoot $aggregate): BusinessRulesNotificationsCollection
    {
        /** @var UsedEquipmentId $usedEquipmentId */
        $usedEquipmentId = AggregatePropertyGetter::getProperty($aggregate, 'usedEquipment');
        $usages = $this->entityManager->getRepository(EquipmentUsage::class)
            ->findBy(['usedEquipment.uuid' => $usedEquipmentId->toString()]);
        $usages[] = $aggregate;

        /** @var array<int, CarbonPeriod> $periods */
        $periods = [];
        foreach ($usages as $usage) {
            $periods[] = AggregatePropertyGetter::getProperty($usage, 'usagePeriod')->getPeriod();
        }

        usort(
            $periods,
            fn(CarbonPeriod $a, CarbonPeriod $b) => $a->getStartDate() <=> $b->getStartDate()
        );

        $notifications = BusinessRulesNotificationsCollection::create();
        for ($i = 1, $len = count($periods); $i < $len; $i++) {
            $prev = $periods[$i - 1];
            $current = $periods[$i];

            if ($current->getStartDate() < $prev->getEndDate()) {
                $notifications->addNotification(
                    BusinessRuleNotification::fromString('Overlapping usage periods detected')
                );
                break;
            }
        }
        return $notifications;
    }
}
