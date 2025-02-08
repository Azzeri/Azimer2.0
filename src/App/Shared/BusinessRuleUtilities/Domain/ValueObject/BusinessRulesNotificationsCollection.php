<?php

declare(strict_types=1);

namespace App\Shared\BusinessRuleUtilities\Domain\ValueObject;

use App\Shared\BusinessRuleUtilities\Domain\Exception\BusinessRuleViolationException;

/**
 * A list of business rules notifications
 *
 * @author Mariusz Waloszczyk
 */
final class BusinessRulesNotificationsCollection
{
    /**
     * @param array<int, BusinessRuleNotification> $notifications
     */
    private function __construct(
        private array $notifications
    ) {
    }

    /**
     * Create a new collection from an array of Notifications
     *
     * @param array<int, BusinessRuleNotification> $notifications
     * @return self
     * @author Mariusz Waloszczyk
     */
    public static function create(array $notifications = []): self
    {
        return new self($notifications);
    }

    /**
     * Add a single notification to the collection
     *
     * @param BusinessRuleNotification $notification
     * @return void
     * @author Mariusz Waloszczyk
     */
    public function addNotification(BusinessRuleNotification $notification): void
    {
        $this->notifications[] = $notification;
    }

    /**
     * Check if there are any notifications and throw exception if so
     *
     * @return void
     * @throws BusinessRuleViolationException
     * @author Mariusz Waloszczyk
     */
    public function validate(): void
    {
        $messages = [];
        foreach ($this->notifications as $notification) {
            $messages[] = $notification->message();
        }

        if ($this->isValid() === false) {
            throw new BusinessRuleViolationException(implode("\n", $messages));
        }
    }

    /**
     * Collection is valid when there are no notifications
     *
     * @return bool
     * @author Mariusz Waloszczyk
     */
    public function isValid(): bool
    {
        return empty($this->notifications);
    }
}
