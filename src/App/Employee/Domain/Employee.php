<?php

declare(strict_types=1);

namespace App\Employee\Domain;

use App\Employee\Application\Command\AddEmployee\AddEmployeeCommand;
use App\Employee\Domain\ValueObject\EmployeeEmail;
use App\Employee\Domain\ValueObject\EmployeeFullName;
use App\Employee\Domain\ValueObject\EmployeeId;
use App\Employee\Domain\ValueObject\EmployeeUnitId;
use App\Employee\Infrastructure\Repository\Persistence\Doctrine\Type\Identifier\EmployeeIdType;
use App\Shared\DomainUtilities\Domain\AggregateRoot;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\ORM\Mapping as ORM;
use Ecotone\Modelling\Attribute as CQRS;
use Symfony\Component\Uid\Uuid;

/**
 * Aggregate of Employee, which represent employee in the fire brigade unit
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Entity]
#[CQRS\Aggregate]
final class Employee extends AggregateRoot
{
    /**
     * @param EmployeeId $id
     * @param EmployeeFullName $fullName
     * @param EmployeeEmail $email
     * @param EmployeeUnitId $employeeUnitId
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        /** @phpstan-ignore-next-line */
        #[CQRS\Identifier]
        #[ORM\Id]
        #[ORM\Column(type: EmployeeIdType::NAME, unique: true)]
        private EmployeeId $id,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: EmployeeFullName::class)]
        private EmployeeFullName $fullName,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: EmployeeEmail::class)]
        private EmployeeEmail $email,
        /** @phpstan-ignore-next-line */
        #[ORM\Embedded(class: EmployeeUnitId::class)]
        private EmployeeUnitId $employeeUnitId,
    ) {
    }

    /**
     * @param AddEmployeeCommand $command
     * @return self
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    #[CQRS\CommandHandler()]
    public static function create(
        AddEmployeeCommand $command,
    ): self {
        // TODO - implement policy checking UserManager permissions, email uniqueness, password rules
        return new self(
            EmployeeId::fromString(Uuid::v4()->toString()),
            EmployeeFullName::create($command->firstName, $command->lastName),
            EmployeeEmail::fromString($command->email),
            EmployeeUnitId::fromString($command->employeeUnitId),
        );
    }

    /**
     * @return EmployeeId
     * @author Mariusz Waloszczyk
     */
    public function getId(): EmployeeId
    {
        return $this->id;
    }

    /**
     * @param EmployeeUnitId $employeeUnitId
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function reassignFireBrigadeUnit(EmployeeUnitId $employeeUnitId): void
    {
        $this->employeeUnitId = $employeeUnitId;
    }
}
