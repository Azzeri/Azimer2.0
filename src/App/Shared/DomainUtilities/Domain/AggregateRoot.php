<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use Ecotone\Modelling\Attribute as CQRS;

/**
 * This class contains common functionalities for domain aggregate roots
 *
 * @author Mariusz Waloszczyk
 */
#[CQRS\Aggregate]
abstract class AggregateRoot
{
}
