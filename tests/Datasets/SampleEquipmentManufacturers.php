<?php

use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;

dataset('sample equipment manufacturers', function () {
    $firstManufacturer = (new EquipmentManufacturerBuilder())
        ->withName(EquipmentManufacturerName::fromString("First manufacturer"))
        ->build();
    $secondManufacturer = (new EquipmentManufacturerBuilder())
        ->withName(EquipmentManufacturerName::fromString("Second manufacturer"))
        ->build();
    $thirdManufacturer = (new EquipmentManufacturerBuilder())
        ->withName(EquipmentManufacturerName::fromString("Third manufacturer"))
        ->build();

    return [
        [
            [
                $firstManufacturer,
                $secondManufacturer,
                $thirdManufacturer,
            ]
        ],
    ];
});
