<?php

declare(strict_types=1);

namespace App\Shared\CommonUtilities;

use ReflectionClass;
use ReflectionException;
use ReflectionProperty;

/**
 * This class contains common operations for reflection
 *
 * @author Mariusz Waloszczyk
 */
final readonly class ReflectionUtils
{
    /**
     * Get the value of reflection property
     *
     * @param object $object
     * @param string $propertyName
     * @return mixed
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public static function getReflectionPropertyValue(object $object, string $propertyName): mixed
    {
        $reflectionProperty = new ReflectionProperty($object, $propertyName);
        return $reflectionProperty->getValue($object);
    }

    /**
     * Invoke private or protected method on the object
     *
     * @param object $object
     * @param string $methodName
     * @param mixed[] $parameters
     * @return mixed
     * @throws ReflectionException
     * @author Mariusz Waloszczyk
     */
    public static function invokeMethod(object $object, string $methodName, array $parameters = []): mixed
    {
        $reflection = new ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);

        return $method->invokeArgs($object, $parameters);
    }
}
