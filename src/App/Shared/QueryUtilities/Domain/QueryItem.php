<?php

declare(strict_types=1);

namespace App\Shared\QueryUtilities\Domain;

/**
 * A common wrapper for API resources
 *
 * @template T
 *
 * @author Mariusz Waloszczyk
 */
final readonly class QueryItem
{
    /**
     * @param string $id
     * @param T $data
     * @author Mariusz Waloszczyk
     */
    private function __construct(
        public string $id,
        public mixed $data
    ) {
    }

    /**
     * @template Item
     * @param string $id
     * @param Item $data
     * @return QueryItem<Item>
     * @author Mariusz Waloszczyk
     */
    public static function create(string $id, mixed $data): self
    {
        return new self($id, $data);
    }
}
