<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine;

use App\Security\Domain\Tenant\Tenant;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use App\Security\Infrastructure\Tenant\Symfony\AuthenticatedUser\AuthenticatedUser;
use App\Shared\CommonUtilities\ReflectionUtils;
use App\Shared\Domain\Repository\StandardRepository;
use App\Shared\DomainUtilities\Domain\IdentifierValueObject;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Exception;
use ReflectionException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * Doctrine implementation of {@see StandardRepository}, mapping between domain Tenant to Doctrine Authenticated User
 * @author Mariusz Waloszczyk
 */
final readonly class TenantDoctrineRepository implements StandardRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param UserPasswordHasherInterface $passwordHasher
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    /**
     * @inheritDoc
     * @throws ORMException|OptimisticLockException|Exception
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findById(IdentifierValueObject $id): Tenant
    {
        if (!$id instanceof TenantId) {
            throw new Exception("Identifier must be value of TenantId");
        }
        return $this->entityManager->find(AuthenticatedUser::class, $id->email())
            ->toTenant();
    }

    /**
     * @inheritDoc
     * @throws ReflectionException|Exception
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function persist(object $object): void
    {
        if (!$object instanceof Tenant) {
            throw new Exception("Object must be value of Tenant");
        }
        $tenantEmail = ReflectionUtils::getReflectionPropertyValue($object, 'id');
        $tenantPassword = ReflectionUtils::getReflectionPropertyValue($object, 'password');
        $tenantStatus = ReflectionUtils::getReflectionPropertyValue($object, 'status');

        $authenticatedUser = new AuthenticatedUser();
        $authenticatedUser->setUserIdentifier($tenantEmail->email());

        $hashedPassword = $this->passwordHasher->hashPassword($authenticatedUser, $tenantPassword->nonHashed());
        $authenticatedUser->setPassword($hashedPassword);
        $authenticatedUser->setStatus($tenantStatus);

        $this->entityManager->persist($authenticatedUser);
        $this->entityManager->flush();
    }
}
