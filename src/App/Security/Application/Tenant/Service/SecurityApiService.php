<?php

declare(strict_types=1);

namespace App\Security\Application\Tenant\Service;

use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * This service should be used by other bounded contexts to get information about security
 *
 * @author Mariusz Waloszczyk
 */
interface SecurityApiService
{
    /**
     * Fetch data of the authenticated tenant
     *
     * @return array{
     *     id: string,
     *     permissions: array<int,string>
     * }
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function getAuthenticatedTenant(): array;
}
