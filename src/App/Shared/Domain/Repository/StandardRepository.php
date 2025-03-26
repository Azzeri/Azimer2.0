<?php

declare(strict_types=1);

namespace App\Shared\Domain\Repository;

use App\Shared\DomainUtilities\Domain\IdentifierValueObject;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;

/**
 * Common interface for aggregate repository
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface StandardRepository
{
    /**
     * Finds aggregate by its ID
     *
     * @param IdentifierValueObject $id
     * @return object
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findById(IdentifierValueObject $id): object;

    /**
     * Persists aggregate in its current state
     *
     * @param object $object
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function persist(object $object): void;
}
