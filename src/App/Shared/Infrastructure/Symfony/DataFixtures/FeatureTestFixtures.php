<?php

namespace App\Shared\Infrastructure\Symfony\DataFixtures;

use App\Employee\Application\Command\AddEmployee\AddEmployeeCommand;
use App\Employee\Domain\Employee;
use App\Security\Application\Tenant\Command\AddTenant\AddTenantCommand;
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
use Symfony\Component\Uid\Uuid;
use Tests\AbstractWebTestCase;

/**
 * These fixtures are loaded before feature tests
 * @psalm-suppress UnusedClass
 * @author Mariusz Waloszczyk
 */
#[Group('test')]
class FeatureTestFixtures extends Fixture implements FixtureGroupInterface
{
    /**
     * @param TenantPasswordService $passwordService
     * @param RoleRepository $repository
     */
    public function __construct(
        private readonly TenantPasswordService $passwordService,
        private readonly RoleRepository $repository
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
        $roleId = RoleId::fromUniqueName(AbstractWebTestCase::TEST_USER_ROLE);
        $manager->persist(Role::create($roleId));

        $command = new AddTenantCommand(
            AbstractWebTestCase::TEST_USER_EMAIL,
            'Azimer1234#.',
            TenantStatus::ACTIVE->value,
            [$roleId->uniqueName()]
        );
        $tenant = Tenant::create($command, $this->passwordService, $this->repository);
        $manager->persist($tenant);

        $employee = new AddEmployeeCommand(
            'John',
            'Doe',
            AbstractWebTestCase::TEST_USER_EMAIL,
            Uuid::v4()->toString()
        );
        $employee = Employee::create($employee);
        $manager->persist($employee);

        $manager->flush();
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public static function getGroups(): array
    {
        return ['test'];
    }
}
