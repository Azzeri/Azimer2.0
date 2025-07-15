<?php

declare(strict_types=1);

namespace Tests\Feature\EquipmentRegister\EquipmentCategory;

use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplatePropertyDefinitionBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Dto\EquipmentTemplateInputDataProperty;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplateProperty;
use App\EquipmentRegister\Domain\EquipmentTemplate\EquipmentTemplate;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\Shared\DomainUtilities\Domain\AggregatePropertyGetter;
use Doctrine\Common\Collections\Collection;
use Tests\SampleProvider\EquipmentRegister\Dto\EquipmentTemplateInputDataBuilder;

beforeEach(function () {
    $this->manufacturer = (new EquipmentManufacturerBuilder())->build();
    $this->category = (new EquipmentCategoryBuilder())->build();
    $this->firstProperty = (new EquipmentTemplatePropertyDefinitionBuilder())->build();
    $this->secondProperty = (new EquipmentTemplatePropertyDefinitionBuilder())->build();

    $this->saveEntities([
        $this->manufacturer,
        $this->category,
        $this->firstProperty,
        $this->secondProperty
    ]);
});

it(
    'creates a new template, when input data is valid and employee is authorized',
    function () {
        // Arrange
        $inputData = (new EquipmentTemplateInputDataBuilder())
            ->withName('Sample template')
            ->withCategory($this->category->getId()->toString())
            ->withManufacturer($this->manufacturer->getId()->toString())
            ->withProperties(
                [
                    new EquipmentTemplateInputDataProperty($this->firstProperty->getId()->toString(), true),
                    new EquipmentTemplateInputDataProperty($this->secondProperty->getId()->toString(), false),
                ]
            )
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-template',
            [EquipmentPermission::TEMPLATE_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(201, $response->getContent());

        $template = $this->getEntity(EquipmentTemplate::class, ['name.name' => 'Sample template']);
        expect($template)
            ->not()
            ->toBeNull()
            ->toHavePrivatePropertyEqualTo('name', EquipmentTemplateName::fromString('Sample template'))
            ->toHavePrivatePropertyEqualTo('category', $this->category)
            ->toHavePrivatePropertyEqualTo('manufacturer', $this->manufacturer);

        /** @var Collection<int, EquipmentTemplateProperty> $properties */
        $properties = AggregatePropertyGetter::getProperty($template, 'properties');
        expect($properties)->toHaveCount(2)
            ->and($properties->get(0))
            ->toHavePrivatePropertyEqualTo('definition', $this->firstProperty)
            ->toHavePrivatePropertyEqualTo('isRequired', true)
            ->and($properties->get(1))
            ->toHavePrivatePropertyEqualTo('definition', $this->secondProperty)
            ->toHavePrivatePropertyEqualTo('isRequired', false);
    }
);

it(
    'fails if template with the requested name already exists',
    function () {
        // Arrange
        $nonUniqueName = 'Template with duplicated name';

        $template = (new EquipmentTemplateBuilder())
            ->withName(EquipmentTemplateName::fromString($nonUniqueName))
            ->withCategory($this->category)
            ->withManufacturer($this->manufacturer)
            ->build();
        $this->saveEntities([$template]);

        $inputData = (new EquipmentTemplateInputDataBuilder())
            ->withName($nonUniqueName)
            ->withCategory($this->category->getId()->toString())
            ->withManufacturer($this->manufacturer->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-template',
            [EquipmentPermission::TEMPLATE_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422, $response->getContent());

        $response = $this->decodeResponse();
        expect($response)->toContain("Template with the given name already exists.");
    }
);

it(
    'fails if template doesn\'t have at least one property',
    function () {
        // Arrange
        $template = (new EquipmentTemplateBuilder())
            ->withCategory($this->category)
            ->withManufacturer($this->manufacturer)
            ->build();
        $this->saveEntities([$template]);

        $inputData = (new EquipmentTemplateInputDataBuilder())
            ->withCategory($this->category->getId()->toString())
            ->withManufacturer($this->manufacturer->getId()->toString())
            ->build();

        // Act
        $response = $this->sendPost(
            $inputData,
            '/api/equipment-template',
            [EquipmentPermission::TEMPLATE_ADD->value]
        );

        // Assert
        expect($response->getStatusCode())
            ->toBe(422, $response->getContent());

        $response = $this->decodeResponse();
        expect($response)->toContain("Template requires at least one property");
    }
);

it(
    'fails if employee is not authorized',
    function () {
        // Arrange
        $inputData = (new EquipmentTemplateInputDataBuilder())
            ->withName('test')
            ->build();

        // Act
        $response = $this->sendPost($inputData, '/api/equipment-template', []);

        // Assert
        expect($response->getStatusCode())
            ->toBe(403, $response->getContent());

        $template = $this->getEntity(EquipmentTemplate::class, ['name.name' => 'test']);
        expect($template)
            ->toBeNull();
    }
);
