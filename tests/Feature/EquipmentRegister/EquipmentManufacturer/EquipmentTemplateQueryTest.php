<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentManufacturer;

use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplatePropertyDefinitionBuilder;

beforeEach(function () {
    $this->category = (new EquipmentCategoryBuilder())->build();
    $this->manufacturer = (new EquipmentManufacturerBuilder())->build();
    $this->firstProperty = (new EquipmentTemplatePropertyDefinitionBuilder())->build();
    $this->secondProperty = (new EquipmentTemplatePropertyDefinitionBuilder())->build();

    $this->template = (new EquipmentTemplateBuilder())
        ->withCategory($this->category)
        ->withManufacturer($this->manufacturer)
        ->build();

    $this->template->assignProperty($this->firstProperty, true);
    $this->template->assignProperty($this->secondProperty, false);

    $this->saveEntities(
        [
            $this->category,
            $this->manufacturer,
            $this->firstProperty,
            $this->secondProperty,
            $this->template
        ]
    );
});

it(
    'retrieves a list of equipment templates',
    function () {
        // TODO - test to check more detailed data
        // Arrange // Act
        $response = $this->sendGet(
            '/api/equipment-template',
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
);

it(
    'retrieves a single equipment template',
    function () {
        // Arrange // Act
        $response = $this->sendGet(
            '/api/equipment-template/' . $this->template->getId(),
            []
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(200, $response->getContent());
    }
);
