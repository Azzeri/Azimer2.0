<?php

declare(strict_types=1);

namespace App\Shared\QueryUtilities\Domain;

/**
 * A common wrapper for collection of API resources
 *
 * @template T
 *
 * @author Mariusz Waloszczyk
 */
final readonly class QueryItemCollection
{
    /**
     * @param int $total
     * @param array<int, QueryItem<T>> $data
     * @author Mariusz Waloszczyk
     */
    public function __construct(
        public int $total,
        public array $data
    ) {
    }

    /**
     * @template Item
     * @param array<int, QueryItem<Item>> $data
     * @return self<Item>
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public static function create(array $data): self
    {
        return new self(count($data), $data);
    }
}
