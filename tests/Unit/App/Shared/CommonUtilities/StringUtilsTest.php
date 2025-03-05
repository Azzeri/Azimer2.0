<?php

namespace Tests\Unit\App\Shared\CommonUtilities;

use App\Shared\CommonUtilities\StringUtils;

it('returns true if length of a string matches the provided parameters', function () {
    // Arrange // Act // Assert
    expect(StringUtils::isLengthBetween('asd', 1, 5))->toBeTrue();
});

it('returns false if length of a string does not match the provided parameters', function () {
    // Arrange // Act // Assert
    expect(StringUtils::isLengthBetween('asdaass', 1, 5))->toBeFalse();
});
