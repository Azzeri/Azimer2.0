<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Policy\TenantCanBeAuthenticated;

use App\Security\Domain\Tenant\Policy\BusinessRule\TenantCanBeAuthenticatedBusinessRule;
use App\Security\Domain\Tenant\Policy\TenantCanBeAuthenticated;
use App\Security\Domain\Tenant\ValueObject\Password;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

/**
 * Implementation of {@see TenantCanBeAuthenticated}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantCanBeAuthenticatedImpl implements TenantCanBeAuthenticated
{
    /**
     * @param iterable<TenantCanBeAuthenticatedBusinessRule> $businessRules
     */
    public function __construct(
        #[AutowireIterator(TenantCanBeAuthenticatedBusinessRule::class)]
        private iterable $businessRules
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function isSatisfiedBy(TenantId $tenantId, Password $password): BusinessRulesNotificationsCollection
    {
        $notifications = BusinessRulesNotificationsCollection::create();

        // TODO - jakies wspolne zasady typu isSatisfiedByAll/isSatisfiedByAtLeastOne
        // https://designpatternsphp.readthedocs.io/en/latest/Behavioral/Specification/README.html
        foreach ($this->businessRules as $businessRule) {
            $businessRuleResult = $businessRule->check($tenantId, $password);
            if ($businessRuleResult !== null) {
                $notifications->addNotification($businessRuleResult);
            }
        }

        return $notifications;
    }
}
