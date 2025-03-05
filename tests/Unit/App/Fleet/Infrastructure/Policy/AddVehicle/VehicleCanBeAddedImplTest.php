<?php

declare(strict_types=1);

namespace Tests\Unit\App\Fleet\Infrastructure\Policy\AddVehicle;

use App\Fleet\Domain\Policy\AddVehicle\BusinessRule\VehicleCanBeAddedBusinessRule;
use App\Fleet\Infrastructure\Policy\AddVehicle\VehicleCanBeAddedImpl;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRuleNotification;
use App\Shared\BusinessRuleUtilities\Domain\ValueObject\BusinessRulesNotificationsCollection;
use Mockery;

it('fail if at least one business rule fails', function () {
    // Arrange
    $successfulRule = Mockery::mock(VehicleCanBeAddedBusinessRule::class);
    $successfulRule->shouldReceive('check')
        ->once()
        ->andReturn(null);

    $failedRule = Mockery::mock(VehicleCanBeAddedBusinessRule::class);
    $failedRule->shouldReceive('check')
        ->once()
        ->andReturn(BusinessRuleNotification::fromString('Failed!!!'));

    $policy = new VehicleCanBeAddedImpl([$successfulRule, $failedRule]);

    // Act
    $result = $policy->isSatisfiedBy();

    // Assert
    expect($result)->toBeInstanceOf(BusinessRulesNotificationsCollection::class)
        ->and($result->isValid())->toBeFalse();
});

it('is successful if all business rules are successful', function () {
    // Arrange
    $successfulRule = Mockery::mock(VehicleCanBeAddedBusinessRule::class);
    $successfulRule->shouldReceive('check')
        ->once()
        ->andReturn(null);

    $policy = new VehicleCanBeAddedImpl([$successfulRule]);

    // Act
    $result = $policy->isSatisfiedBy();

    // Assert
    expect($result)->toBeInstanceOf(BusinessRulesNotificationsCollection::class)
        ->and($result->isValid())->toBeTrue();
});
