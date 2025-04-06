<?php

declare(strict_types=1);

namespace App\Employee\Domain\ValueObject;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Full name of an employee
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EmployeeFullName
{
    /**
     * @param string $firstName
     * @param string $lastName
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $firstName,
        #[ORM\Column(type: Types::STRING)]
        private string $lastName,
    ) {
    }

    /**
     * @param string $firstName
     * @param string $lastName
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(string $firstName, string $lastName): self
    {
        return new self($firstName, $lastName);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function fullName(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
