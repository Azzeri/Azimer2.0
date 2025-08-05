<?php

namespace App\Shared\Infrastructure\Symfony\DataFixtures;

use App\Employee\Application\Command\AddEmployee\AddEmployeeCommand;
use App\Employee\Domain\Employee;
use App\EquipmentRegister\Domain\Equipment\Builder\EquipmentBuilder;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentOwnerId;
use App\EquipmentRegister\Domain\Equipment\ValueObject\EquipmentPropertyValue;
use App\EquipmentRegister\Domain\EquipmentCategory\Builder\EquipmentCategoryBuilder;
use App\EquipmentRegister\Domain\EquipmentCategory\EquipmentCategory;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryId;
use App\EquipmentRegister\Domain\EquipmentCategory\ValueObject\EquipmentCategoryName;
use App\EquipmentRegister\Domain\EquipmentManufacturer\Builder\EquipmentManufacturerBuilder;
use App\EquipmentRegister\Domain\EquipmentManufacturer\EquipmentManufacturer;
use App\EquipmentRegister\Domain\EquipmentManufacturer\ValueObject\EquipmentManufacturerName;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplateBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Builder\EquipmentTemplatePropertyDefinitionBuilder;
use App\EquipmentRegister\Domain\EquipmentTemplate\Entity\EquipmentTemplatePropertyDefinition;
use App\EquipmentRegister\Domain\EquipmentTemplate\Enum\EquipmentTemplatePropertyDefinitionType;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplateName;
use App\EquipmentRegister\Domain\EquipmentTemplate\ValueObject\EquipmentTemplatePropertyDefinitionName;
use App\EquipmentRegister\Domain\Shared\Enum\EquipmentPermission;
use App\EquipmentUsage\Domain\Builder\EquipmentUsageBuilder;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsageDescription;
use App\EquipmentUsage\Domain\ValueObject\EquipmentUsingPersonId;
use App\EquipmentUsage\Domain\ValueObject\UsedEquipmentId;
use App\FireBrigadeUnit\Application\Command\AddFireBrigadeUnit\AddFireBrigadeUnitCommand;
use App\FireBrigadeUnit\Domain\FireBrigadeUnit;
use App\FireBrigadeUnit\Domain\Repository\FireBrigadeUnitRepository;
use App\Fleet\Domain\Enum\FleetPermission;
use App\Security\Application\Tenant\Command\AddTenant\AddTenantCommand;
use App\Security\Domain\Resource\Resource;
use App\Security\Domain\Resource\ValueObject\ResourceId;
use App\Security\Domain\Role\Repository\RoleRepository;
use App\Security\Domain\Role\Role;
use App\Security\Domain\Role\ValueObject\RoleId;
use App\Security\Domain\Tenant\Enum\TenantStatus;
use App\Security\Domain\Tenant\Service\TenantPasswordService;
use App\Security\Domain\Tenant\Tenant;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\Attributes\Group;

/**
 * These fixtures contain base data useful for development of the application
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Group('dev')]
class DevelopmentFixture extends Fixture implements FixtureGroupInterface
{
    /**
     * @param TenantPasswordService $passwordService
     * @param RoleRepository $repository
     * @param FireBrigadeUnitRepository $fireBrigadeUnitRepository
     */
    public function __construct(
        private readonly TenantPasswordService $passwordService,
        private readonly RoleRepository $repository,
        private readonly FireBrigadeUnitRepository $fireBrigadeUnitRepository,
    ) {
    }

    /**
     * Create sample user and a sample role for feature tests.
     * Selected permissions for this role are loaded in every request.
     *
     * @param ObjectManager $manager
     * @return void
     * @throws InvalidDataException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    public function load(ObjectManager $manager): void
    {
        $roleId = RoleId::fromUniqueName('Administrator');
        $role = Role::create($roleId);

        $permissions = [
            Resource::create(ResourceId::fromUniqueName(FleetPermission::ADD_ALL->value)),
            Resource::create(ResourceId::fromUniqueName(EquipmentPermission::MANUFACTURER_ADD->value)),
            Resource::create(ResourceId::fromUniqueName(EquipmentPermission::CATEGORY_ADD->value)),
        ];
        foreach ($permissions as $permission) {
            $this->repository->persist($permission);
            $role->assignResource($permission);
        }
        $manager->persist($role);

        $unit = new AddFireBrigadeUnitCommand();
        $unit = FireBrigadeUnit::create($unit, $this->fireBrigadeUnitRepository);
        $manager->persist($unit);


        $command = new AddTenantCommand(
            'admin@azimer.com',
            'Azimer1234#.',
            TenantStatus::ACTIVE->value,
            [$roleId->uniqueName()]
        );
        $tenant = Tenant::create($command, $this->passwordService, $this->repository);
        $manager->persist($tenant);

        $employee = new AddEmployeeCommand(
            'Azimer',
            'Admin',
            'admin@azimer.com',
            (string)$unit->getId()
        );
        $employee = Employee::create($employee);
        $manager->persist($employee);

        $categories = $this->prepareCategories();
        $manufacturers = $this->prepareManufacturers();
        $properties = $this->preparePropertyDefinitions();

        foreach ($categories as $category) {
            $manager->persist($category);
        }

        foreach ($manufacturers as $manufacturer) {
            $manager->persist($manufacturer);
        }

        foreach ($properties as $property) {
            $manager->persist($property);
        }

        $template = (new EquipmentTemplateBuilder())
            ->withName(EquipmentTemplateName::fromString("Butla Honeywell stalowa"))
            ->withCategory($categories[0])
            ->withManufacturer($manufacturers[0])
            ->build();

        foreach ($properties as $property) {
            $template->assignProperty($property, true);
        }

        $manager->persist($template);

        $equipment = (new EquipmentBuilder())
            ->withOwner(EquipmentOwnerId::fromString($unit->getId()->toString()))
            ->withTemplate($template)
            ->build();

        $equipment->assignPropertyValue(
            $properties[0]->getId(),
            EquipmentPropertyValue::fromString('serial number 123456')
        );

        $equipment->assignPropertyValue(
            $properties[1]->getId(),
            EquipmentPropertyValue::fromString('2025-10-10')
        );

        $equipment->assignPropertyValue(
            $properties[2]->getId(),
            EquipmentPropertyValue::fromString('YES')
        );

        $equipment->assignPropertyValue(
            $properties[3]->getId(),
            EquipmentPropertyValue::fromString('33,654')
        );

        $manager->persist($equipment);

        $usage = (new EquipmentUsageBuilder())
            ->withUsedEquipmentId(UsedEquipmentId::fromString($equipment->getId()->toString()))
            ->withUsingPersonId(EquipmentUsingPersonId::fromString($employee->getId()->toString()))
            ->withDescription(EquipmentUsageDescription::create('Jakiś tam opis'))
            ->build();

        $manager->persist($usage);
        $manager->flush();
    }

    /**
     * @return array<int, EquipmentCategory>
     * @author Mariusz Waloszczyk
     */
    private function prepareCategories(): array
    {
        $parentCategoryId = EquipmentCategoryId::generate();
        $firstSubcategoryId = EquipmentCategoryId::generate();
        $secondSubcategoryId = EquipmentCategoryId::generate();
        $parentCategoryName = EquipmentCategoryName::fromString("Oxygen bottle");
        $firstSubcategoryName = EquipmentCategoryName::fromString("Steel bottle");
        $secondSubcategoryName = EquipmentCategoryName::fromString("Non-steel bottle");

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

        return [$parentCategory, $firstSubcategory, $secondSubcategory];
    }

    /**
     * @return array<int, EquipmentManufacturer>
     * @author Mariusz Waloszczyk
     */
    private function prepareManufacturers(): array
    {
        $firstManufacturer = (new EquipmentManufacturerBuilder())
            ->withName(EquipmentManufacturerName::fromString("Aeris"))
            ->build();
        $secondManufacturer = (new EquipmentManufacturerBuilder())
            ->withName(EquipmentManufacturerName::fromString("Honeywell"))
            ->build();
        $thirdManufacturer = (new EquipmentManufacturerBuilder())
            ->withName(EquipmentManufacturerName::fromString("FireProof"))
            ->build();

        return [$firstManufacturer, $secondManufacturer, $thirdManufacturer];
    }

    /**
     * @return array<int, EquipmentTemplatePropertyDefinition>
     * @author Mariusz Waloszczyk
     */
    private function preparePropertyDefinitions(): array
    {
        $serialNumber = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withName(EquipmentTemplatePropertyDefinitionName::fromString("Serial number"))
            ->withType(EquipmentTemplatePropertyDefinitionType::TEXT)
            ->build();

        $expiryDate = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withName(EquipmentTemplatePropertyDefinitionName::fromString("Expiry date"))
            ->withType(EquipmentTemplatePropertyDefinitionType::DATE)
            ->build();

        $isFillable = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withName(EquipmentTemplatePropertyDefinitionName::fromString("Can be filled?"))
            ->withType(EquipmentTemplatePropertyDefinitionType::YES_NO)
            ->build();

        $price = (new EquipmentTemplatePropertyDefinitionBuilder())
            ->withName(EquipmentTemplatePropertyDefinitionName::fromString("Price"))
            ->withType(EquipmentTemplatePropertyDefinitionType::DECIMAL)
            ->build();

        return [$serialNumber, $expiryDate, $isFillable, $price];
    }


    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public static function getGroups(): array
    {
        return ['dev'];
    }
}
