<?php

declare(strict_types=1);

namespace App\Fleet\Domain\Factory;

use App\Fleet\Domain\ValueObject\FleetManager;

/**
 * This factory should be used to create instances of FleetManager
 *
 * @author Mariusz Waloszczyk
 */
interface FleetManagerFactory
{
    /**
     * Create instance of FleetManager based on the authenticated user
     *
     * @return FleetManager
     * @author Mariusz Waloszczyk
     */
    public function fromAuthenticatedUser(): FleetManager;
}
