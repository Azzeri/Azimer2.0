<?php

declare(strict_types=1);

namespace App\Security\Domain\Role;

use App\Security\Domain\Resource\Resource;
use App\Security\Domain\Role\ValueObject\RoleId;
use App\Security\Domain\Tenant\Tenant;
use App\Security\Infrastructure\Role\Repository\Persistence\Doctrine\Type\Identifier\RoleUniqueNameType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * ACL role that can be assigned to user. Every role has many resources assigned
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
final class Role extends AggregateRoot
{
    /**
     * @param RoleId $name
     * @param Collection<int, Resource> $resources
     * @param Collection<int, Tenant> $tenants
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        /** @phpstan-ignore-next-line */
        #[ORM\Id]
        #[CQRS\Identifier]
        #[ORM\Column(type: RoleUniqueNameType::NAME, length: RoleId::MAX_LENGTH, unique: true)]
        private RoleId $name,
        /** @phpstan-ignore-next-line */
        #[ORM\ManyToMany(targetEntity: Resource::class, inversedBy: 'roles', cascade: ['persist'])]
        #[ORM\JoinTable(
            name: 'role_resource',
            joinColumns: [new ORM\JoinColumn(name: 'role_id', referencedColumnName: 'name')],
            inverseJoinColumns: [new ORM\JoinColumn(name: 'resource_id', referencedColumnName: 'name')]
        )]
        private Collection $resources = new ArrayCollection(),
        /** @phpstan-ignore-next-line */
        #[ORM\ManyToMany(targetEntity: Tenant::class, mappedBy: 'roles')]
        private Collection $tenants = new ArrayCollection()
    ) {
    }

    /**
     * @param RoleId $roleId
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(RoleId $roleId): self
    {
        return new self($roleId);
    }

    /**
     * Assign resource to role if not assigned
     *
     * @param Resource $resource
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function assignResource(Resource $resource): void
    {
        if (!$this->resources->contains($resource)) {
            $this->resources->add($resource);
        }
    }
}
