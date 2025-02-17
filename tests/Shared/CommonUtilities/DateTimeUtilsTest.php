<?php

declare(strict_types=1);

namespace App\Tests\Shared\CommonUtilities;

use App\Shared\CommonUtilities\DateTimeUtils;

it('returns true if a month is valid', function () {
    // Arrange // Act // Assert
    expect(DateTimeUtils::isValidMonth(2))->toBeTrue();
});

it('returns false if a month is invalid', function () {
    // Arrange // Act // Assert
    expect(DateTimeUtils::isValidMonth(22))->toBeFalse();
});
