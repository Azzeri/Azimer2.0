<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use Tests\SampleProvider\EquipmentRegister\Dto\EquipmentCategoryInputDataBuilder;

it(
    'creates a new category without parent category, when input data is valid and employee is authorized',
    function () {
        // Arrange
        $inputData = (new EquipmentCategoryInputDataBuilder())->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-category',
            [EquipmentPermission::CATEGORY_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $category = $this->getEntity(EquipmentCategory::class, ['name.name' => 'Helmet']);
        expect($category)
            ->not()
            ->toBeNull()
            ->toHavePrivatePropertyEqualTo('name', EquipmentCategoryName::fromString('Helmet'));
    }
);

it(
    'creates a new category with parent category, when input data is valid and employee is authorized',
    function () {
        // Arrange
        $parentCategory = (new EquipmentCategoryBuilder())
            ->withName(EquipmentCategoryName::fromString('Parent Helmet'))
            ->build();

        $this->saveEntities([$parentCategory]);
        $inputData = (new EquipmentCategoryInputDataBuilder())
            ->withParentCategory($parentCategory->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost($inputData, '/api/equipment-category', [EquipmentPermission::CATEGORY_ADD->value]);

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $category = $this->getEntity(EquipmentCategory::class, ['name.name' => 'Helmet']);
        expect($category)
            ->not()
            ->toBeNull()
            ->toHavePrivatePropertyEqualTo('parentCategory', $parentCategory);
    }
);

it(
    'fails if category with the requested name already exists',
    function () {
        // Arrange
        $nonUniqueName = 'Helmet';

        $parentCategory = (new EquipmentCategoryBuilder())
            ->withName(EquipmentCategoryName::fromString($nonUniqueName))
            ->build();
        $this->saveEntities([$parentCategory]);

        $inputData = (new EquipmentCategoryInputDataBuilder())
            ->withName($nonUniqueName)
            ->withParentCategory($parentCategory->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-category',
            [EquipmentPermission::CATEGORY_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422, $response->getContent());
    }
);

it(
    'fails if employee is not authorized',
    function () {
        // Arrange
        $inputData = (new EquipmentCategoryInputDataBuilder())->build();

        // Act
        $response = $this->sendPost($inputData, '/api/equipment-category', []);

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent());

        $category = $this->getEntity(EquipmentCategory::class, ['name.name' => 'Helmet']);
        expect($category)
            ->toBeNull();
    }
);
