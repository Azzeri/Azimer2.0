<?php

declare(strict_types=1);

namespace App\Security\Application\Tenant\Command\AddTenant;

/**
 * Command creating a new Tenant
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AddTenantCommand
{
    /**
     * @param string $email
     * @param string $password
     * @param string $status
     * @param array<int, string> $roles
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $email,
        #[\SensitiveParameter]
        public string $password,
        public string $status,
        public array $roles,
    ) {
    }
}
