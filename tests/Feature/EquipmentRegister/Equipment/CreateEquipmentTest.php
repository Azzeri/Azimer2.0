<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\Equipment\Dto\EquipmentInputDataProperty;
use App\EquipmentRegister\Domain\Equipment\Entity\EquipmentProperty;
use App\EquipmentRegister\Domain\Equipment\Enum\EquipmentStatus;
use App\EquipmentRegister\Domain\Equipment\Equipment;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplatePropertyDefinitionBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\FireBrigadeUnit\Domain\ValueObject\FireBrigadeUnitId;
use App\Shared\CommonUtilities\ReflectionUtils;
use Doctrine\Common\Collections\Collection;
use Tests\SampleProvider\EquipmentRegister\Dto\EquipmentInputDataBuilder;

/**
 *
 * cases:
 * - success if authorized to all and data is valid
 * - failed if own and not authorized to add to own
 * - failed if subservient and not authorized to add to subservient
 * - success if own and authorized to own
 * - success if subservient and authorized to subservient
 * - failed if not all required properties were provided
 * - failed if not nullable property provided as null
 * - failed if invalid property values were provided
 * */
beforeEach(function () {
    $sampleData = [
        $this->manufacturer = (new EquipmentManufacturerBuilder())->build(),
        $this->category = (new EquipmentCategoryBuilder())->build(),

        $this->template = (new EquipmentTemplateBuilder())
            ->withCategory($this->category)
            ->withManufacturer($this->manufacturer)
            ->build(),

        $this->textProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::TEXT)
            ->build(),
        $this->dateProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::DATE)
            ->build(),
        $this->dateTimeProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::DATE_TIME)
            ->build(),
        $this->floatProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::DECIMAL)
            ->build(),
        $this->integerProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::INTEGER)
            ->build(),
        $this->yesNoProperty = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withType(EquipmentTemplatePropertyDefinitionType::YES_NO)
            ->build(),
    ];

    $this->saveEntities($sampleData);
});

it(
    'creates a new equipment, when input data is valid and employee is authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->template->assignProperty($this->dateProperty, true);
        $this->template->assignProperty($this->dateTimeProperty, true);
        $this->template->assignProperty($this->textProperty, true);
        $this->template->assignProperty($this->integerProperty, true);
        $this->template->assignProperty($this->floatProperty, true);
        $this->saveEntities([$this->template]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
            new EquipmentInputDataProperty($this->dateProperty->getId()->toString(), '2024-10-10'),
            new EquipmentInputDataProperty($this->dateTimeProperty->getId()->toString(), '2024-10-10 11:00:12'),
            new EquipmentInputDataProperty($this->textProperty->getId()->toString(), 'some text'),
            new EquipmentInputDataProperty($this->integerProperty->getId()->toString(), '2232'),
            new EquipmentInputDataProperty($this->floatProperty->getId()->toString(), '33.45'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_ALL_UNITS->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();
        $equipment = end($equipment);

        expect($equipment)
            ->not()
            ->toBeNull()
            ->toHavePrivatePropertyEqualTo('status', EquipmentStatus::ACTIVE)
            ->toHavePrivatePropertyEqualTo('ownerId', $ownerId);

        /** @var Collection<int, EquipmentProperty> $properties */
        $properties = ReflectionUtils::getReflectionPropertyValue($equipment, 'properties');
        expect($properties)->toHaveCount(6);

        $firstProperty = $properties->get(0);
        $secondProperty = $properties->get(1);
        $thirdProperty = $properties->get(2);
        $fourthProperty = $properties->get(3);
        $fifthProperty = $properties->get(4);
        $sixthProperty = $properties->get(5);

        expect($firstProperty->getValue())
            ->toEqual('YES')
            ->and($firstProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::YES_NO)
            ->and($secondProperty->getValue())
            ->toEqual('2024-10-10')
            ->and($secondProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::DATE)
            ->and($thirdProperty->getValue())
            ->toEqual('2024-10-10 11:00:12')
            ->and($thirdProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::DATE_TIME)
            ->and($fourthProperty->getValue())
            ->toEqual('some text')
            ->and($fourthProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::TEXT)
            ->and($fifthProperty->getValue())
            ->toEqual('2232')
            ->and($fifthProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::INTEGER)
            ->and($sixthProperty->getValue())
            ->toEqual('33.45')
            ->and($sixthProperty->getEquipmentTemplateProperty()->getPropertyType())
            ->toBe(EquipmentTemplatePropertyDefinitionType::DECIMAL);
    }
);

it(
    'creates a new equipment with null value if allowed',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $this->template->assignProperty($this->yesNoProperty, false);
        $this->saveEntities([$this->template]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), null),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_ALL_UNITS->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();
        $equipment = end($equipment);

        expect($equipment)
            ->not()
            ->toBeNull();

        /** @var Collection<int, EquipmentProperty> $properties */
        $properties = ReflectionUtils::getReflectionPropertyValue($equipment, 'properties');
        expect($properties->get(0)->getValue())
            ->toEqual(EquipmentPropertyValue::empty());
    }
);

it(
    'fails if user tries to assign to own unit, but is not authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->saveEntities([$this->template, $unit]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_SUBSERVIENT_UNITS->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(403)
            ->and($response->getContent())
            ->toContain('Fleet manager is not authorized to add equipment for the requested unit');

        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();

        expect($equipment)
            ->toBeEmpty();
    }
);

it(
    'creates equipment for own unit if authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->saveEntities([$this->template, $unit]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_OWN_UNIT->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201);

        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();

        expect($equipment[0])
            ->not()
            ->toBeEmpty();
    }
);

it(
    'fails if user tries to assign to subservient unit, but is not authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $subservientUnit = new FireBrigadeUnit(FireBrigadeUnitId::generate(), $unit);

        $this->template->assignProperty($this->yesNoProperty, true);
        $this->saveEntities([$this->template, $unit, $subservientUnit]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($subservientUnit->getId()->toString())
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_OWN_UNIT->value],
            $ownerId
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(403)
            ->and($response->getContent())
            ->toContain('Fleet manager is not authorized to add equipment for the requested unit');

        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();

        expect($equipment)
            ->toBeEmpty();
    }
);

it(
    'creates equipment for subservient unit if authorized',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $unit = new FireBrigadeUnit(FireBrigadeUnitId::fromString($ownerId));
        $subservientUnit = new FireBrigadeUnit(FireBrigadeUnitId::generate(), $unit);

        $this->template->assignProperty($this->yesNoProperty, true);
        $this->saveEntities([$this->template, $unit, $subservientUnit]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($subservientUnit->getId()->toString())
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_SUBSERVIENT_UNITS->value],
            $ownerId
        );

        // Assert
        $equipment = $this->entityManager->getRepository(Equipment::class)
            ->findAll();

        expect($equipment[0])
            ->not()
            ->toBeNull();
    }
);


it(
    'fails if not all required properties are required',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->template->assignProperty($this->dateProperty, true);
        $this->saveEntities([$this->template]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'YES'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_ALL_UNITS->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422)
            ->and($response->getContent())
            ->toContain(
                "Property for template property definition: {$this->dateProperty->getId()} not found",
                "Invalid number of properties corresponding to template"
            );
    }
);

it(
    'fails if not nullable property is provided as null',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->saveEntities([$this->template]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), null),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_ALL_UNITS->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422)
            ->and($response->getContent())
            ->toContain(
                "Property for template property definition: {$this->yesNoProperty->getId()} can not be empty",
            );
    }
);

it(
    'fails if provided properties values are invalid',
    function () {
        // Arrange
        $ownerId = EquipmentOwnerId::generate()->toString();
        $this->template->assignProperty($this->yesNoProperty, true);
        $this->template->assignProperty($this->dateProperty, true);
        $this->template->assignProperty($this->dateTimeProperty, true);
        $this->template->assignProperty($this->integerProperty, true);
        $this->template->assignProperty($this->floatProperty, true);
        $this->saveEntities([$this->template]);

        $properties = [
            new EquipmentInputDataProperty($this->yesNoProperty->getId()->toString(), 'invalid'),
            new EquipmentInputDataProperty($this->dateProperty->getId()->toString(), 'invalid'),
            new EquipmentInputDataProperty($this->dateTimeProperty->getId()->toString(), 'invalid'),
            new EquipmentInputDataProperty($this->integerProperty->getId()->toString(), 'invalid'),
            new EquipmentInputDataProperty($this->floatProperty->getId()->toString(), 'invalid'),
        ];
        $inputData = (new EquipmentInputDataBuilder())
            ->withTemplateId($this->template->getId()->toString())
            ->withOwnerId($ownerId)
            ->withProperties($properties)
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment',
            [EquipmentPermission::EQUIPMENT_ADD_ALL_UNITS->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422, $response->getContent())
            ->and($response->getContent())
            ->toContain(
                "Invalid property value: invalid for type: yes_no",
                "Invalid property value: invalid for type: date",
                "Invalid property value: invalid for type: date_time",
                "Invalid property value: invalid for type: integer",
                "Invalid property value: invalid for type: decimal",
            );
    }
);
