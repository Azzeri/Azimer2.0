<?php

declare(strict_types=1);

namespace App\EquipmentUsage\Domain\ValueObject;

use App\Shared\DomainUtilities\Domain\ValueObject;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * A description for equipment usage
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class EquipmentUsageDescription extends ValueObject
{
    /**
     * @param string $body
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING, length: 512, nullable: true)]
        private string $body,
    ) {
    }

    /**
     * @param string $body
     * @return EquipmentUsageDescription
     * @author Mariusz Waloszczyk
     */
    public static function create(string $body): EquipmentUsageDescription
    {
        return new self($body);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function __toString(): string
    {
        return $this->body;
    }
}
