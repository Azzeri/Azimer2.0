<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Policy\AddVehicle;

use App\Fleet\Application\Command\AddVehicleCommand;
use App\Fleet\Domain\Factory\FleetManagerFactory;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\VehicleCanBeAddedBusinessRule;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see VehicleCanBeAdded}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleCanBeAddedImpl implements VehicleCanBeAdded
{
    /**
     * @param iterable<VehicleCanBeAddedBusinessRule> $businessRules
     * @param FleetManagerFactory $fleetManagerFactory
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        #[AutowireIterator(VehicleCanBeAddedBusinessRule::class)]
        private iterable $businessRules,
        private FleetManagerFactory $fleetManagerFactory,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function checkBusinessRules(AddVehicleCommand $command): BusinessRulesNotificationsCollection
    {
        $authenticatedEmployee = $this->fleetManagerFactory->fromAuthenticatedEmployee();

        $notifications = BusinessRulesNotificationsCollection::create();
        foreach ($this->businessRules as $businessRule) {
            $businessRuleResult = $businessRule->check($command, $authenticatedEmployee);
            if ($businessRuleResult !== null) {
                $notifications->addNotification($businessRuleResult);
            }
        }

        return $notifications;
    }
}
