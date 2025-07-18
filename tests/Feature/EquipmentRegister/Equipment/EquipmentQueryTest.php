<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentManufacturer;

use App\EquipmentRegister\Domain\Equipment\Builder\EquipmentBuilder;

it(
    'retrieves a list of equipments',
    function () {
        // TODO - test to check more detailed data
        // Arrange
        $equipments = [
            (new EquipmentBuilder())->build(),
            (new EquipmentBuilder())->build(),
        ];
        $this->saveEntities($equipments);

        // Act
        $response = $this->sendGet(
            '/api/equipment',
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
);

it(
    'retrieves a single equipment',
    function () {
        // Arrange
        $equipments = [
            (new EquipmentBuilder())->build(),
            (new EquipmentBuilder())->build(),
        ];
        $this->saveEntities($equipments);

        // Act
        $response = $this->sendGet(
            '/api/equipment/' . $equipments[0]->getId(),
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
);
