<?php

declare(strict_types=1);

namespace App\Employee\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * An email of the employee, also serving as its tenant identifier
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EmployeeEmail extends ValueObject
{
    /**
     * @param string $email
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING)]
        private string $email,
    ) {
    }

    /**
     * @param string $email
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $email): self
    {
        return new self($email);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function toString(): string
    {
        return $this->email;
    }
}
