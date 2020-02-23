<?php

namespace TaskForce\Tasks\Actions;
use TaskForce\Tasks\Status;

class AcceptAction extends AbstractAction
{
    public static function getTitle(): string
    {
        return 'Принять';
    }

    public static function getName(): string
    {
        return Status::ACTION_ACCEPT;
    }

    public static function isAvailable(Status $status, int $userId, string $userRole): bool
    {
        if ($userId === $status->getCustomerId()
        && $userRole === Status::ROLE_CUSTOMER
        && $status->getCurrentStatus() === Status::STATUS_WORK) {
            return true;
        }
        return false;
    }
}