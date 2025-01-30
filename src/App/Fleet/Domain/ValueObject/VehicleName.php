<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\CommonUtilities\StringUtils;
use App\Shared\DomainUtilities\Domain\ValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Name of the vehicle, including its make and model
 *
 * @author Mariusz Waloszczyk
 */
#[ORM\Embeddable]
final readonly class VehicleName extends ValueObject
{
    public const int MIN_ELEMENT_LENGTH = 1;
    public const int MAX_ELEMENT_LENGTH = 64;

    /**
     * @param string $make
     * @param string $model
     * @throws InvalidDataException
     */
    private function __construct(
        #[ORM\Column(type: Types::STRING, length: self::MAX_ELEMENT_LENGTH)]
        private string $make,
        #[ORM\Column(type: Types::STRING, length: self::MAX_ELEMENT_LENGTH)]
        private string $model
    ) {
        $this->validate();
    }

    /**
     * Create a new instance from make and model
     *
     * @param string $make
     * @param string $model
     * @return self
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    public static function fromMakeAndModel(string $make, string $model): self
    {
        return new self($make, $model);
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function make(): string
    {
        return $this->make;
    }

    /**
     * @return string
     * @author Mariusz Waloszczyk
     */
    public function model(): string
    {
        return $this->model;
    }

    /**
     * @param VehicleName $object
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function equals(VehicleName $object): bool
    {
        return $this->make === $object->make()
            && $this->model === $object->model();
    }

    /**
     * @return void
     * @throws InvalidDataException
     * @author Mariusz Waloszczyk
     */
    private function validate(): void
    {
        if (!StringUtils::isLengthBetween($this->make, self::MIN_ELEMENT_LENGTH, self::MAX_ELEMENT_LENGTH)) {
            throw new InvalidDataException("Vehicle make must be between 1 and 64 characters.");
        }

        if (!StringUtils::isLengthBetween($this->model, self::MIN_ELEMENT_LENGTH, self::MAX_ELEMENT_LENGTH)) {
            throw new InvalidDataException("Vehicle model must be between 1 and 64 characters.");
        }
    }
}
