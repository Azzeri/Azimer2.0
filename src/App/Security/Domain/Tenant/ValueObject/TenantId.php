<?php

declare(strict_types=1);

namespace App\Security\Domain\Tenant\ValueObject;

use App\Shared\DomainUtilities\Domain\IdentifierValueObject;

/**
 * Identifier of a tenant
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
final readonly class TenantId extends IdentifierValueObject
{
    /**
     * @param string $email
     * @return TenantId
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function fromEmail(string $email): TenantId
    {
        return new self($email);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function email(): string
    {
        return $this->email;
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function __toString(): string
    {
        return $this->email();
    }

    /**
     * @param string $email
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    private function __construct(private string $email)
    {
    }
}
