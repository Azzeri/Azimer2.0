<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

/**
 * This class contains common functionalities for domain value objects that serve as identifiers
 *
 * @author Mariusz Waloszczyk
 */
abstract readonly class IdentifierValueObject extends ValueObject implements \Stringable
{
}
