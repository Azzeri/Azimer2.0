<?php

declare(strict_types=1);

namespace App\Employee\Infrastructure\Repository\Persistence\Doctrine;

use App\Employee\Domain\Dto\EmployeeQueryModel;
use App\Employee\Domain\Employee;
use App\Employee\Domain\Repository\EmployeeQueryModelRepository;
use App\Employee\Domain\ValueObject\EmployeeEmail;
use App\Employee\Domain\ValueObject\EmployeeId;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query;

/**
 * Doctrine implementation of {@see EmployeeQueryModelRepository}
 *
 * @author Mariusz Waloszczyk
 */
final readonly class EmployeeQueryModelDoctrineRepository implements EmployeeQueryModelRepository
{
    /**
     * @param EntityManagerInterface $entityManager
     * @author Mariusz Waloszczyk
     */
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function findByIdentifier(EmployeeId $identifier): ?EmployeeQueryModel
    {
        $employee = $this->getByProperty('id', (string)$identifier);
        return null === $employee ? null : $this->mapToDto($employee);
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function findByEmail(EmployeeEmail $email): ?EmployeeQueryModel
    {
        $employee = $this->getByProperty('email.email', $email->toString());
        return null === $employee ? null : $this->mapToDto($employee);
    }

    /**
     * @param string $property
     * @param string $value
     * @return mixed[]|null
     * @author Mariusz Waloszczyk
     */
    private function getByProperty(string $property, string $value): ?array
    {
        return $this->entityManager
            ->createQueryBuilder()
            ->select('e')
            ->from(Employee::class, 'e')
            ->where("e.$property = :id")
            ->setParameter('id', $value)
            ->getQuery()
            ->getOneOrNullResult(Query::HYDRATE_ARRAY);
    }

    /**
     * @param array $employee
     * @return EmployeeQueryModel
     * @author Mariusz Waloszczyk
     */
    private function mapToDto(array $employee): EmployeeQueryModel
    {
        return new EmployeeQueryModel(
            (string)$employee['id'],
            $employee['fullName.firstName'],
            $employee['fullName.lastName'],
            $employee['email.email'],
            (string)$employee['employeeUnitId.uuid'],
        );
    }
}
