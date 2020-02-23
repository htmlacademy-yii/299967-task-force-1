<?php

namespace TaskForce\Tasks\Actions;
use TaskForce\Tasks\Status;

class OfferAction extends AbstractAction
{
    public static function getTitle(): string
    {
        return 'Откликнуться';
    }

    public static function getName(): string
    {
        return Status::ACTION_OFFER;
    }

    public static function isAvailable(Status $status, int $userId, string $userRole): bool
    {
        if ($userId !== $status->getCustomerId() 
        && $userRole === Status::ROLE_EXECUTOR 
        && $status->getCurrentStatus() === Status::STATUS_NEW) {
            return true;
        }
        return false;
    }
}