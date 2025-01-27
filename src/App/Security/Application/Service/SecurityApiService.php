<?php

declare(strict_types=1);

namespace App\Security\Application\Service;

/**
 * This service can be used by other bounded contexts to fetch data about security
 *
 * @author Mariusz Waloszczyk
 */
interface SecurityApiService
{
    /**
     * Fetch data of the authenticated user
     *
     * @return array{
     *     id: string,
     *     fireBrigadeUnitId: string,
     *     permissions: array<int,string>
     * }
     * @author Mariusz Waloszczyk
     */
    public function getAuthenticatedUser(): array;
}
