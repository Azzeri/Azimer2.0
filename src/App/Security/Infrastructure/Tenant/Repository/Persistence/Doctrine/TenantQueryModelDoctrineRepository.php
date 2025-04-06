<?php

declare(strict_types=1);

namespace App\Security\Infrastructure\Tenant\Repository\Persistence\Doctrine;

use App\Security\Domain\Tenant\Dto\TenantQueryModel;
use App\Security\Domain\Tenant\Repository\TenantQueryRepository;
use App\Security\Domain\Tenant\ValueObject\TenantId;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;

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
     * @throws Exception
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByIdentifier(TenantId $identifier): ?TenantQueryModel
    {
        $connection = $this->entityManager
            ->getConnection();

        $sql = "
            SELECT t.email, t.password_hashed, t.status, r.name AS role_name, res.name AS resource_name
            FROM tenant t
            JOIN tenant_role tr ON t.email = tr.tenant_id
            JOIN role r ON tr.role_id = r.name
            JOIN role_resource rr ON r.name = rr.role_id
            JOIN resource res ON rr.resource_id = res.name
            WHERE t.email = :tenantId
        ";

        $stmt = $connection->prepare($sql);
        $stmt->bindValue(':tenantId', $identifier->email());

        $results = $stmt->executeQuery()
            ->fetchAllAssociative();

        if (empty($results)) {
            return null;
        }

        $roles = [];
        $resources = [];

        foreach ($results as $row) {
            $roles[] = $row['role_name'];
            $resources[] = $row['resource_name'];
        }

        return new TenantQueryModel(
            $results[0]['email'],
            $results[0]['password_hashed'],
            $results[0]['status'],
            array_unique($roles),
            array_unique($resources)
        );
    }
}
