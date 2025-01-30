<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\UuidIdentifier;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * Identifier of a fire brigade unit to which a fleet is assigned
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class AssignedUnitId extends UuidIdentifier
{
    /**
     * @param Uuid $uuid
     */
    protected function __construct(
        #[ORM\Column(type: "uuid")]
        protected Uuid $uuid
    ) {
    }
}
