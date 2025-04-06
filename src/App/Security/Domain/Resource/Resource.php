<?php

declare(strict_types=1);

namespace App\Security\Domain\Resource;

use App\Security\Domain\Resource\ValueObject\ResourceId;
use App\Security\Domain\Role\Role;
use App\Security\Infrastructure\Resource\Repository\Persistence\Doctrine\Type\Identifier\ResourceUniqueNameType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;

/**
 * ACL resource that can be assigned to a role
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
#[ORM\Entity]
#[CQRS\Aggregate]
final class Resource extends AggregateRoot
{
    /**
     * @param ResourceId $name
     * @param Collection<int, Role> $resources
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        /** @phpstan-ignore-next-line */
        #[ORM\Id]
        #[CQRS\Identifier]
        #[ORM\Column(type: ResourceUniqueNameType::NAME, length: ResourceId::MAX_LENGTH, unique: true)]
        private ResourceId $name,

        /** @phpstan-ignore-next-line */
        #[ORM\ManyToMany(targetEntity: Role::class, mappedBy: 'roles')]
        private Collection $resources
    ) {
    }
}
