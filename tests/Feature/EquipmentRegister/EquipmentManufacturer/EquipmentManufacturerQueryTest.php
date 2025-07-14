<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;

it(
    'retrieves a list of equipment manufacturers',
    /**
     * @param array<int, EquipmentManufacturer> $manufacturers
     */
    function (array $manufacturers) {
        // TODO - test to check more detailed data
        // Arrange
        $this->saveEntities($manufacturers);

        // Act
        $response = $this->sendGet(
            '/api/equipment-manufacturer',
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
)->with('sample equipment manufacturers');

it(
    'retrieves a single equipment manufacturer',
    /**
     * @param array<int, EquipmentManufacturer> $manufacturers
     */
    function (array $manufacturers) {
        // Arrange
        $this->saveEntities($manufacturers);

        // Act
        $response = $this->sendGet(
            '/api/equipment-manufacturer/' . $manufacturers[0]->getId(),
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
)->with('sample equipment manufacturers');
