<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

/**
 * A common class for actors performing actions in the application
 *
 * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
 */
abstract readonly class Actor extends ValueObject
{
    /**
     * @param string $identifier
     * @param array $permissions
     * @param string $organizationalUnitId
     */
    public function __construct(
        protected string $identifier,
        protected array $permissions,
        protected string $organizationalUnitId
    ) {
    }

    /**
     * Check if actor has a permission
     *
     * @param string $permission
     * @return bool
     * @author Mariusz Waloszczyk<mwaloszczyk@ottoworkforce.eu>
     */
    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->permissions);
    }
}
