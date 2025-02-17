<?php

declare(strict_types=1);

namespace App\Tests\Shared\BusinessRuleUtilities\Domain\ValueObject;

use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;

it('returns its message', function () {
    // Arrange
    $notification = BusinessRuleNotification::fromString('note');

    // Act // Assert
    expect($notification)->message()
        ->toEqual('note');
});
