<?php

namespace App\EquipmentUsage\Domain;

use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageDescription;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageId;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsagePeriod;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsingPersonId;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\EquipmentUsage\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier\EquipmentUsageIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate representing a single usage of an equipment
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class EquipmentUsage extends AggregateRoot
{
    /**
     * @param EquipmentUsageId $id
     * @param EquipmentUsagePeriod $usagePeriod
     * @param UsedEquipmentId $usedEquipment
     * @param EquipmentUsingPersonId $usingPerson
     * @param EquipmentUsageDescription|null $description
     */
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentUsageIdType::NAME, unique: true)]
        private EquipmentUsageId $id,
        #[ORM\Embedded(class: EquipmentUsagePeriod::class)]
        private EquipmentUsagePeriod $usagePeriod,
        #[ORM\Embedded(class: UsedEquipmentId::class)]
        private UsedEquipmentId $usedEquipment,
        #[ORM\Embedded(class: EquipmentUsingPersonId::class)]
        private EquipmentUsingPersonId $usingPerson,
        #[ORM\Embedded(class: EquipmentUsageDescription::class)]
        private ?EquipmentUsageDescription $description = null,
    ) {
    }
}
