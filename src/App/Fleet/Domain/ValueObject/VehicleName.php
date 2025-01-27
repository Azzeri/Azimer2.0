<?php

declare(strict_types=1);

namespace App\Fleet\Domain\ValueObject;

use App\Shared\CommonUtilities\StringUtils;
use App\Shared\DomainUtilities\Domain\ValueObject;
use App\Shared\DomainUtilities\Exception\InvalidDataException;

/**
 * Name of the vehicle, including its make and model
 *
 * @author Mariusz Waloszczyk
 */
final readonly class VehicleName extends ValueObject
{
    /**
     * @param string $make
     * @param string $model
     * @throws InvalidDataException
     */
    private function __construct(private string $make, private string $model)
    {
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
        if (!StringUtils::isLengthBetween($this->make, 1, 64)) {
            throw new InvalidDataException("Vehicle make must be between 1 and 64 characters.");
        }

        if (!StringUtils::isLengthBetween($this->model, 1, 64)) {
            throw new InvalidDataException("Vehicle model must be between 1 and 64 characters.");
        }
    }
}
