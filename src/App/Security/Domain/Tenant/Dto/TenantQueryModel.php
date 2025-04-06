<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\Dto;

/**
 * Query model of a tenant
 *
 * @author Mariusz Waloszczyk
 */
final readonly class TenantQueryModel
{
    /**
     * @param string $email
     * @param string $password
     * @param string $status
     * @param array<int, string> $roles
     * @param array<int, string> $resources
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public string $email,
        #[\SensitiveParameter]
        public string $password,
        public string $status,
        public array $roles,
        public array $resources
    ) {
    }
}
