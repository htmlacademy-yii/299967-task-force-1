<?php

namespace TaskForce\Tasks\Actions;
use TaskForce\Tasks\Status;

class RefuseAction extends AbstractAction
{
    public static function getTitle(): string
    {
        return 'Отказаться';
    }

    public static function getName(): string
    {
        return Status::ACTION_REFUSE;
    }

    public static function isAvailable(Status $status, int $userId, string $userRole): bool
    {
        if ($userId === $status->getExecutorId() 
        && $userRole === Status::ROLE_EXECUTOR 
        && $status->getCurrentStatus() === Status::STATUS_WORK) {
            return true;
        }
        return false;
    }
}