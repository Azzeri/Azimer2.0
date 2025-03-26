<?php

declare(strict_types=1);

namespace App\Shared\CqrsUtilities\Domain\Repository;

use App\Shared\CqrsUtilities\Domain\ValueObject\RuntimeMessage;

/**
 * Class that is able to collect messages during request. Later they can be read by key, for example, in the controller.
 * The Intention of the class is collecting messages from commands or events without breaking the CQRS principle.
 *
 * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
 */
interface RuntimeMessageCollectorRepository
{
    /**
     * Add a new message
     *
     * @param RuntimeMessage $message
     * @return void
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function addMessage(RuntimeMessage $message): void;

    /**
     * Get all collected messages
     *
     * @return RuntimeMessage[]
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function getMessages(): array;

    /**
     * Find specific messages by a key
     * @param string $key
     * @return array<int, string>
     * @author Mariusz Waloszczyk <mwaloszczyk@ottoworkforce.eu>
     */
    public function findByKey(string $key): array;
}
