<?php

declare(strict_types=1);

namespace Tests\Unit\App\Shared\CommonUtilities;

use App\Shared\CommonUtilities\ReflectionUtils;
use ReflectionException;
use Tests\SampleProvider\SampleClass;

it(
    'returns a private property of an object',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $object = new SampleClass('test name');

        // Act // Assert
        expect(ReflectionUtils::getReflectionPropertyValue($object, 'name'))->toBe('test name');
    }
);

it(
    'invokes a private method of an object',
    /**
     * @throws ReflectionException
     */
    function () {
        // Arrange
        $object = new SampleClass('test name');

        // Act // Assert
        expect(ReflectionUtils::invokeMethod($object, 'getName'))->toBe('test name');
    }
);
