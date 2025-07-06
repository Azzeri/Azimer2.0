<?php

declare(strict_types=1);

namespace App\Shared\DomainUtilities\Domain;

use App\Shared\CommonUtilities\ReflectionUtils;
use ReflectionException;

/**
 * Aggregates shouldn't have too many unnecessary getters, so this class can be used to retrieve their parameters
 *
 * @author Mariusz Waloszczyk
 */
final readonly class AggregatePropertyGetter
{
    /**
     * Get aggregate property
     *
     * @param AggregateRoot $aggregate
     * @param string $propertyName
     * @return mixed
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public static function getProperty(AggregateRoot $aggregate, string $propertyName): mixed
    {
        return ReflectionUtils::getReflectionPropertyValue($aggregate, $propertyName);
    }
}
