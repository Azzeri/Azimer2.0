<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine;

use App\Security\Domain\Tenant\Dto\TenantQueryModel;
use App\Security\Domain\Tenant\Repository\TenantQueryRepository;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUser;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;

/**
 * Doctrine implementation of {@see TenantQueryRepository}
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantQueryModelDoctrineRepository implements TenantQueryRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @throws ORMException|OptimisticLockException
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByIdentifier(TenantId $identifier): ?TenantQueryModel
    {
        $tenant = $this->entityManager->find(AuthenticatedUser::class, $identifier->email());

        if (null === $tenant) {
            return null;
        }

        return new TenantQueryModel(
            $tenant->getUserIdentifier(),
            $tenant->getPassword(),
            $tenant->getStatus()->value,
            $tenant->getRoles(),
        );
    }
}
