<?php

declare(strict_types=1);

namespace App\Security\Application\Command\AuthenticateTenant;

/**
 * Command to authenticate tenant in the system
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class AuthenticateTenantCommand
{
    /**
     * @param string $email
     * @param string $password
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        public string $email,
        #[\SensitiveParameter]
        public string $password
    ) {
    }
}
