<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Dto\EquipmentManufacturerInputData;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use Tests\SampleProvider\EquipmentRegister\Dto\EquipmentManufacturerInputDataBuilder;

it(
    'creates a new manufacturer, when input data is valid and employee is authorized',
    function () {
        // Arrange
        $inputData = new EquipmentManufacturerInputData("Google");

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-manufacturer',
            [EquipmentPermission::MANUFACTURER_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $manufacturer = $this->getEntity(EquipmentManufacturer::class, ['name.name' => 'Google']);
        expect($manufacturer)
            ->not()
            ->toBeNull()
            ->toHavePrivatePropertyEqualTo('name', EquipmentManufacturerName::fromString('Google'));
    }
);

it(
    'fails if manufacturer with the requested name already exists',
    function () {
        // Arrange
        $nonUniqueName = 'Google';

        $parentCategory = (new EquipmentManufacturerBuilder())
            ->withName(EquipmentManufacturerName::fromString($nonUniqueName))
            ->build();
        $this->saveEntities([$parentCategory]);

        $inputData = (new EquipmentManufacturerInputDataBuilder())
            ->withName($nonUniqueName)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-manufacturer',
            [EquipmentPermission::MANUFACTURER_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422, $response->getContent());

        $response = $this->decodeResponse();
        expect($response)->toBe("Manufacturer with the given name already exists.");
    }
);

it(
    'fails if employee is not authorized',
    function () {
        // Arrange
        $inputData = (new EquipmentManufacturerInputDataBuilder())->build();

        // Act
        $response = $this->sendPost($inputData, '/api/equipment-manufacturer', []);

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent());

        $category = $this->getEntity(EquipmentManufacturer::class, ['name.name' => 'Manufacturer']);
        expect($category)
            ->toBeNull();
    }
);
