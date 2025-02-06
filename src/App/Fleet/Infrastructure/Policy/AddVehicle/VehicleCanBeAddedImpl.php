<?php

declare(strict_types=1);

namespace App\Fleet\Infrastructure\Policy\AddVehicle;

use App\Fleet\Domain\Dto\VehicleInputData;
use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\VehicleCanBeAddedBusinessRule;
use App\Fleet\Domain\Policy\AddVehicle\VehicleCanBeAdded;
use App\Fleet\Domain\ValueObject\FleetManager;
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
     * @param iterable $businessRules
     */
    public function __construct(
        #[AutowireIterator(VehicleCanBeAddedBusinessRule::class)]
        private iterable $businessRules
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(
        ?VehicleInputData $inputData = null,
        ?FleetManager $fleetManager = null
    ): BusinessRulesNotificationsCollection {
        $notifications = BusinessRulesNotificationsCollection::create();

        /** @var VehicleCanBeAddedBusinessRule $businessRule */
        foreach ($this->businessRules as $businessRule) {
            $businessRuleResult = $businessRule->check($inputData, $fleetManager);
            if ($businessRuleResult !== null) {
                $notifications->addNotification($businessRuleResult);
            }
        }

        return $notifications;
    }
}
