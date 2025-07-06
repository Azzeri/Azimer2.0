<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

/**
 * A common interface for the factory creating an actor performing actions in the system
 *
 * @template T of Actor
 *
 * @author Mariusz Waloszczyk
 */
interface ActorFactory
{
    /**
     * Create an actor
     *
     * @return T
     * @author Mariusz Waloszczyk
     */
    public function create(): Actor;
}
