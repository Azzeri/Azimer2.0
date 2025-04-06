<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Hashed password, usually persisted in this form
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class HashedPassword extends ValueObject
{
    /**
     * @param string $password
     * @return HashedPassword
     * @author Mariusz Waloszczyk
     */
    public static function fromString(string $password): HashedPassword
    {
        return new self($password);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function toString(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        #[ORM\Column(name: "hashed", type: Types::STRING)]
        private string $password,
    ) {
    }
}
