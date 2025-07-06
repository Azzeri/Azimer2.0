<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant;

use App\Security\Application\Tenant\Command\AddTenant\AddTenantCommand;
use App\Security\Domain\Role\Repository\RoleRepository;
use App\Security\Domain\Role\Role;
use App\Security\Domain\Role\ValueObject\RoleId;
use App\Security\Domain\Tenant\Enum\TenantStatus;
use App\Security\Domain\Tenant\Service\TenantPasswordService;
use App\Security\Domain\Tenant\ValueObject\HashedPassword;
use App\Security\Domain\Tenant\ValueObject\PlainPassword;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine\Type\Identifier\TenantEmailType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Messaging\Attribute\Parameter\Reference;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * Aggregate of Tenant, which represent person using the system
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
final class Tenant extends AggregateRoot
{
    /**
     * @param TenantId $email
     * @param HashedPassword $password
     * @param TenantStatus $status
     * @param Collection<int, Role> $roles
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        /** @phpstan-ignore-next-line */
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: TenantEmailType::NAME, unique: true)]
        private TenantId $email,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: HashedPassword::class)]
        private HashedPassword $password,
        /** @phpstan-ignore-next-line */
        #[ORM\Column(type: Types::STRING, enumType: TenantStatus::class)]
        private TenantStatus $status,
        /** @phpstan-ignore-next-line */
        #[ORM\ManyToMany(targetEntity: Role::class, inversedBy: 'tenants', cascade: ['persist'])]
        #[ORM\JoinTable(
            name: 'tenant_role',
            joinColumns: [new ORM\JoinColumn(name: 'tenant_id', referencedColumnName: 'email')],
            inverseJoinColumns: [new ORM\JoinColumn(name: 'role_id', referencedColumnName: 'name')]
        )]
        private Collection $roles
    ) {
    }

    /**
     * Create a new tenant
     *
     * @param AddTenantCommand $command
     * @param TenantPasswordService $hasher
     * @param RoleRepository $roleRepository
     * @return self
     * @throws ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    #[CQRS\CommandHandler()]
    public static function create(
        AddTenantCommand $command,
        #[Reference] TenantPasswordService $hasher,
        #[Reference] RoleRepository $roleRepository,
    ): self {
        // TODO - implement policy checking UserManager permissions, email uniqueness, password rules
        $roles = array_map(
            fn(string $role) => $roleRepository->findById(RoleId::fromUniqueName($role)),
            $command->roles
        );
        /** @var Collection<int, Role> $rolesCollection */
        $rolesCollection = new ArrayCollection($roles);

        $tenantId = TenantId::fromEmail($command->email);

        return new self(
            $tenantId,
            $hasher->hash(PlainPassword::fromString($command->password), $tenantId),
            TenantStatus::from($command->status),
            $rolesCollection
        );
    }

    /**
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isActive(): bool
    {
        return $this->status === TenantStatus::ACTIVE;
    }
}
