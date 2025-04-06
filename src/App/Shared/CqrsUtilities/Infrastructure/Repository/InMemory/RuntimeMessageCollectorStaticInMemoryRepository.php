<?php

declare(strict_types=1);

namespace App\Shared\CqrsUtilities\Infrastructure\Repository\InMemory;

use App\Shared\CqrsUtilities\Domain\Repository\RuntimeMessageCollectorRepository;
use App\Shared\CqrsUtilities\Domain\ValueObject\RuntimeMessage;

/**
 * Adapter for {@see RuntimeMessageCollectorRepository} collecting messages statically in memory
 *
 * @author Mariusz Waloszczyk
 */
class RuntimeMessageCollectorStaticInMemoryRepository implements RuntimeMessageCollectorRepository
{
    /**
     * Message collected during one lifecycle
     *
     * @var RuntimeMessage[]
     * @author Mariusz Waloszczyk
     */
    private static array $messages;

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function addMessage(RuntimeMessage $message): void
    {
        self::$messages[] = $message;
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function getMessages(): array
    {
        return self::$messages ?? [];
    }

    /**
     * @inheritDoc
     * @author Mariusz Waloszczyk
     */
    public function findByKey(string $key): array
    {
        return array_filter(
            self::$messages,
            fn(RuntimeMessage $message) => $message->key() === $key
        );
    }
}
