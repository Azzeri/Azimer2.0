<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Policy\TenantCanBeAuthenticated\BusinessRule;

use App\Security\Domain\Tenant\Policy\BusinessRule\PasswordAndEmailAreCorrect;
use App\Security\Domain\Tenant\Service\TenantPasswordService;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;

/**
 * Implementation of {@see PasswordAndEmailAreCorrect}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class PasswordAndEmailAreCorrectImpl implements PasswordAndEmailAreCorrect
{
    /**
     * @param TenantPasswordService $tenantPasswordService
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private TenantPasswordService $tenantPasswordService,
    ) {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function check(
        TenantId $tenantId,
        PlainPassword $password
    ): ?BusinessRuleNotification {
        return $this->tenantPasswordService->isPasswordValid($password, $tenantId)
            ? null
            : BusinessRuleNotification::fromString("Incorrect password");
    }
}
