<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;

it(
    'retrieves a list of equipment categories with a valid hierarchy',
    /**
     * @param array<int, EquipmentCategory> $categories
     */
    function (array $categories) {
        // TODO - test to check more detailed data
        // Arrange
        $this->saveEntities($categories);

        // Act
        $response = $this->sendGet(
            '/api/equipment-category',
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
)->with('sample equipment categories');

it(
    'retrieves a single equipment category with a valid hierarchy',
    /**
     * @param array<int, EquipmentCategory> $categories
     */
    function (array $categories) {
        // Arrange
        $this->saveEntities($categories);

        // Act
        $response = $this->sendGet(
            '/api/equipment-category/' . $categories[0]->getId(),
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
)->with('sample equipment categories');
