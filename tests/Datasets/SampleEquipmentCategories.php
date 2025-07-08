<?php

use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;

dataset('sample equipment categories', function () {
    $parentCategoryId = EquipmentCategoryId::generate();
    $firstSubcategoryId = EquipmentCategoryId::generate();
    $secondSubcategoryId = EquipmentCategoryId::generate();
    $parentCategoryName = EquipmentCategoryName::fromString("Vest");
    $firstSubcategoryName = EquipmentCategoryName::fromString("Sub-Vest 1");
    $secondSubcategoryName = EquipmentCategoryName::fromString("Sub-Vest 2");

    $parentCategory = (new EquipmentCategoryBuilder())
        ->withId($parentCategoryId)
        ->withName($parentCategoryName)
        ->build();

    $firstSubcategory = (new EquipmentCategoryBuilder())
        ->withId($firstSubcategoryId)
        ->withName($firstSubcategoryName)
        ->withParent($parentCategory)
        ->build();

    $secondSubcategory = (new EquipmentCategoryBuilder())
        ->withId($secondSubcategoryId)
        ->withName($secondSubcategoryName)
        ->withParent($parentCategory)
        ->build();

    return [
        [
            [
                $parentCategory,
                $firstSubcategory,
                $secondSubcategory,
            ]
        ],
    ];
});
