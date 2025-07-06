<?php

declare(strict_types=1);

namespace App\FireBrigadeUnit\Domain;

use App\FireBrigadeUnit\Application\Command\AddFireBrigadeUnit\AddFireBrigadeUnitCommand;
use App\FireBrigadeUnit\Domain\Repository\FireBrigadeUnitRepository;
use App\FireBrigadeUnit\Domain\ValueObject\FireBrigadeUnitId;
use App\FireBrigadeUnit\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier\FireBrigadeUnitIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use App\Shared\DomainUtilities\Exception\ResourceNotFoundException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Messaging\Attribute\Parameter\Reference;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 * Aggregate representing fire brigade units in system
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
class FireBrigadeUnit extends AggregateRoot
{
    /**
     * @param FireBrigadeUnitId $id
     * @param FireBrigadeUnit|null $superiorUnit
     * @param Collection $subservientUnits
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: FireBrigadeUnitIdType::NAME, unique: true)]
        private FireBrigadeUnitId $id,
        #[ORM\ManyToOne(targetEntity: FireBrigadeUnit::class, inversedBy: 'subservientUnits')]
        private ?FireBrigadeUnit $superiorUnit = null,
        #[ORM\OneToMany(targetEntity: FireBrigadeUnit::class, mappedBy: 'superiorUnit', cascade: ['persist'])]
        private Collection $subservientUnits = new ArrayCollection()
    ) {
    }

    /**
     * @param AddFireBrigadeUnitCommand $command
     * @param FireBrigadeUnitRepository $fireBrigadeUnitRepository
     * @return self
     * @throws InvalidDataException|ResourceNotFoundException
     * @author Mariusz Waloszczyk
     */
    #[CQRS\CommandHandler]
    public static function create(
        AddFireBrigadeUnitCommand $command,
        #[Reference] FireBrigadeUnitRepository $fireBrigadeUnitRepository,
    ): self {
        // TODO - policy
        $superiorUnit = $command->superiorUnitId
            ? $fireBrigadeUnitRepository->findById(FireBrigadeUnitId::fromString($command->superiorUnitId))
            : null;

        return new self(
            FireBrigadeUnitId::fromString(Uuid::v4()->toString()),
            $superiorUnit,
            new ArrayCollection()
        );
    }

    /**
     * @return FireBrigadeUnitId
     * @author Mariusz Waloszczyk
     */
    public function getId(): FireBrigadeUnitId
    {
        return $this->id;
    }

    /**
     * @param FireBrigadeUnitId $fireBrigadeUnitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isSuperiorOf(FireBrigadeUnitId $fireBrigadeUnitId): bool
    {
        /** @var FireBrigadeUnit $subservient */
        foreach ($this->subservientUnits as $subservient) {
            if ($subservient->getId()->equals($fireBrigadeUnitId)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @param FireBrigadeUnitId $fireBrigadeUnitId
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isSubservientTo(FireBrigadeUnitId $fireBrigadeUnitId): bool
    {
        return $this->superiorUnit->getId()->equals($fireBrigadeUnitId);
    }
}
