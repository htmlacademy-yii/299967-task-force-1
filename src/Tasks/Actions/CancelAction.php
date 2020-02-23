<?php

namespace TaskForce\Tasks\Actions;
use TaskForce\Tasks\Status;

class CancelAction extends AbstractAction
{
    public static function getTitle(): string
    {
        return 'Отменить';
    }

    public static function getName(): string
    {
        return Status::ACTION_CANCEL;
    }

    public static function isAvailable(Status $status, int $userId, string $userRole): bool
    {
        if ($userId === $status->getCustomerId() 
        && $userRole === Status::ROLE_CUSTOMER 
        && $status->getCurrentStatus() === Status::STATUS_NEW) {
            return true;
        }
        return false;
    }
}