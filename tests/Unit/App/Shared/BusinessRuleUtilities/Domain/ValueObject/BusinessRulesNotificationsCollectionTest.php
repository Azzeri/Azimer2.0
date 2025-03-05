<?php

declare(strict_types=1);

namespace Tests\Unit\App\Shared\BusinessRuleUtilities\Domain\ValueObject;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;

it(
    'throws exception if there is at least one notification',
    /**
     * @throws BusinessRuleViolationException
     */
    function () {
        // Arrange
        $collection = BusinessRulesNotificationsCollection::create();
        $collection->addNotification(BusinessRuleNotification::fromString('notification'));

        // Act // Assert
        expect(
            fn() => $collection->validate()
        )->toThrow(BusinessRuleViolationException::class, "notification");
    }
);

it(
    'is valid if has no notifications',
    /**
     * @throws BusinessRuleViolationException
     */
    function () {
        // Arrange
        $collection = BusinessRulesNotificationsCollection::create();
        $collection->validate();

        // Act // Assert
        expect($collection->isValid())->toBeTrue();
    }
);
