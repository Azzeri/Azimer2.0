<?php

declare(strict_types=1);

namespace App\Security\Domain\Role\ValueObject;

use App\Shared\DomainUtilities\Domain\IdentifierValueObject;

/**
 * Unique identifier of ACL role
 *
 * @author Mariusz Waloszczyk
 */
final readonly class RoleId extends IdentifierValueObject
{
    public const int MAX_LENGTH = 64;

    /**
     * @param string $name
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function fromUniqueName(string $name): self
    {
        return new self($name);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function uniqueName(): string
    {
        return $this->uniqueName;
    }

    public function __toString(): string
    {
        return $this->uniqueName;
    }

    /**
     * @param string $uniqueName
     * @author Mariusz Waloszczyk
     */
    private function __construct(private string $uniqueName)
    {
    }
}
