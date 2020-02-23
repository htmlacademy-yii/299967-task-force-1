<?php

require_once __DIR__ . '/vendor/autoload.php';

use TaskForce\Tasks\Status;

$followingStatus = 'При выборе действия "%1s" задание перейдёт в статус "%2s"';
foreach (Status::getActions() as $action) {
    assert(in_array(Status::getFollowingStatus($action), Status::getStatuses()));
    printf($followingStatus, $action::getName(), Status::getFollowingStatus($action));
    print '<br>';
}

print '<br>';
$customerId = 1;
$executorId = 2;
$termExecution = '2020-01-31';

$userId = 1;
$userRole = 'customer';
$currentStatus = 'new';
$statusOne = new Status($customerId, $executorId, $termExecution, $currentStatus);
assert(in_array(Status::ACTION_CANCEL, $statusOne->getAvailableActions($userId, $userRole)));
assert(in_array(Status::ACTION_WORK, $statusOne->getAvailableActions($userId, $userRole)));
print 'Статус задания - Новое, Пользователь - автор задания, Статус пользователя - Заказчик, <br>
Доступные действия: ' . implode(', ', $statusOne->getAvailableActions($userId, $userRole));

