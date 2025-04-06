<?php

declare(strict_types=1);

namespace App\Security\Application\Tenant\Command\AuthenticateTenant;

/**
 * Command to authenticate tenant in the system
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AuthenticateTenantCommand
{
    /**
     * @param string $email
     * @param string $password
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $email,
        #[\SensitiveParameter]
        public string $password
    ) {
    }
}
