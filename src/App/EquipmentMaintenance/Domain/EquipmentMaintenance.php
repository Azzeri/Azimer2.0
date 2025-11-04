<?php

declare(strict_types=1);

namespace App\EquipmentMaintenance\Domain;

use App\EquipmentMaintenance\Domain\Event\MaintenanceWasCompleted;
use App\EquipmentMaintenance\Domain\ValueObject\AssignedToId;
use App\EquipmentMaintenance\Domain\ValueObject\EquipmentMaintenanceDescription;
use App\EquipmentMaintenance\Domain\ValueObject\EquipmentMaintenanceId;
use App\EquipmentMaintenance\Domain\ValueObject\MaintainedEquipmentId;
use App\EquipmentMaintenance\Domain\ValueObject\PerformedById;
use App\EquipmentMaintenance\Domain\ValueObject\MaintenancePeriod;
use App\EquipmentMaintenance\Domain\ValueObject\PeriodUntilNextMaintenance;
use App\EquipmentMaintenance\Domain\ValueObject\PlannedMaintenanceDate;
use App\EquipmentMaintenance\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier\EquipmentMaintenanceIdType;
use App\EquipmentUsage\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier\EquipmentUsageIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Carbon\Carbon;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;
use Ecotone\Modelling\WithEvents;

#[CQRS\Aggregate]
#[ORM\Entity]
final class EquipmentMaintenance extends AggregateRoot
{
    use WithEvents;

    /**
     * @param EquipmentMaintenanceId $id
     * @param MaintainedEquipmentId $maintainedEquipmentId
     * @param PerformedById $assignedTo
     * @param PlannedMaintenanceDate $plannedMaintenanceDate
     * @param MaintenancePeriod|null $maintenancePeriod
     * @param PerformedById|null $performedBy
     * @param PeriodUntilNextMaintenance|null $periodUntilNextMaintenance
     * @param EquipmentMaintenanceDescription|null $description
     */
    public function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EquipmentMaintenanceIdType::NAME, unique: true)]
        private EquipmentMaintenanceId $id,

        #[ORM\Embedded(class: MaintainedEquipmentId::class)]
        private MaintainedEquipmentId $maintainedEquipmentId,

        #[ORM\Embedded(class: AssignedToId::class)]
        private AssignedToId $assignedTo,

        #[ORM\Embedded(class: PlannedMaintenanceDate::class)]
        private PlannedMaintenanceDate $plannedMaintenanceDate,

        #[ORM\Embedded(class: MaintenancePeriod::class)]
        private ?MaintenancePeriod $maintenancePeriod,

        #[ORM\Embedded(class: PerformedById::class)]
        private ?PerformedById $performedBy,

        #[ORM\Embedded(class: PeriodUntilNextMaintenance::class)]
        private ?PeriodUntilNextMaintenance $periodUntilNextMaintenance,

        #[ORM\Embedded(class: EquipmentMaintenanceDescription::class)]
        private ?EquipmentMaintenanceDescription $description
    ) {
    }

    public function complete(
        PerformedById $performedBy,
        MaintenancePeriod $maintenancePeriod,
        ?Carbon $nextMaintenanceDate
    ): void {
        $this->performedBy = $performedBy;
        $this->maintenancePeriod = $maintenancePeriod;

        $this->recordThat(new MaintenanceWasCompleted($this->id, $nextMaintenanceDate));
    }

    /**
     * User wybiera sprzet albo szablon
     * User tworzy serwis z interwalem albo bez
     * Serwis sie tworzy z planowana data dla sprzetu albo wszystkich sprzetow spod szablonu (w API opcja na wybranie tablicy sprzetow dla ktorych zrobic maintenance)
     *
     * User oznacza serwis jako wykonany
     * zaktualizuj daty i performedBy
     * jesli serwis mial interwal, to stworz nowy serwis z data startu po tym interwale (chyba ze user chce inaczej, domyslnie ma tworzyc)
     *
     * User edytuje serwis
     * User usuwa serwis (tylko jesli niewykonany)
     */
}
