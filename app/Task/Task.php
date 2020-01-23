<?php

namespace app\Task;

class Task
{
    const ROLE_CLIENT = 'client'; // заказчик
    const ROLE_EXECUTOR = 'executor'; // исполнитель
    const ROLE_SELECTED_EXECUTOR = 'selected-executor'; // выбранный исполнитель

    const STATUS_NEW = 'new'; // новое
    const STATUS_EXECUTION = 'execution'; // выполняется
    const STATUS_COMPLETED = 'completed'; // завершено
    const STATUS_CANCELED = 'canceled'; // отменено
    const STATUS_FAILING = 'failing'; // провалено
    const STATUS_EXPIRED = 'expired'; // просрочено

    const ACTION_COMPLETED = 'completed'; // выполнить
    const ACTION_DENIAL = 'denial'; // отказаться
    const ACTION_CANCEL = 'cancel'; // отменить
    const ACTION_RESPOND = 'respond'; // откликнуться

    private $id = null;
    private $title = null;
    private $description = null;
    private $category = null;
    private $files = null;
    private $location = null;
    private $price = null;
    private $date_end = null;

    private $role = null;
    private $executor_id = null;
    private $client_id = null;
    private $current_status = null;

    private $errors = [];

    public function __construct($data = [])
    {
        $this->id = $data['id'] ?? null;
        $this->title = $data['title'] ?? null;
        $this->description = $data['description'] ?? null;
        $this->category = $data['category'] ?? null;
        $this->files = $data['files'] ?? null;
        $this->location = $data['location'] ?? null;
        $this->price = $data['price'] ?? null;
        $this->date_end = $data['date_end'] ?? null;

        $this->executor_id = $data['executor_id'] ?? null;
        $this->client_id = $data['client_id'] ?? null;

        if (in_array($data['status'], $this->getStatusList())) {
            $this->current_status = $data['status'];
        } elseif (isset($this->date_end) && strtotime($this->date_end) < time()) {
            $this->current_status = self::STATUS_EXPIRED;
        } else {
            $this->current_status = self::STATUS_NEW;
        }

        $this->role = in_array($data['role'], $this->getRoleList()) ? $data['role'] : self::ROLE_EXECUTOR;
    }

    public function getRoleList()
    {
        return [
            self::ROLE_CLIENT,
            self::ROLE_EXECUTOR,
            self::ROLE_SELECTED_EXECUTOR
        ];
    }

    public function getStatusList()
    {
        return [
            self::STATUS_NEW,
            self::STATUS_EXECUTION,
            self::STATUS_COMPLETED,
            self::STATUS_CANCELED,
            self::STATUS_FAILING,
            self::STATUS_EXPIRED,
        ];
    }

    public function getActionsList()
    {
        return [
            self::ACTION_COMPLETED,
            self::ACTION_DENIAL,
            self::ACTION_CANCEL,
            self::ACTION_RESPOND,
        ];
    }

    public function getNextStatus($action)
    {
        return in_array($action, $this->getActionsList()) ?
            $this->current_status = [
                self::ACTION_COMPLETED => self::STATUS_COMPLETED,
                self::ACTION_DENIAL => self::STATUS_FAILING,
                self::ACTION_CANCEL => self::STATUS_CANCELED
            ][$action] : null;
    }

    private function getAvailableActions()
    {
        $actions = [];

        switch ($this->role) {
            case self::ROLE_CLIENT: // заказчик
                $actions[] = self::ACTION_COMPLETED; // завершить

                if ($this->current_status === self::STATUS_NEW) { // если задание новое
                    $actions[] = self::ACTION_CANCEL; // отменить
                }
                break;
            case self::ROLE_EXECUTOR: // исполнитель
                $actions[] = self::ACTION_RESPOND; // отозваться
                break;
            case self::ROLE_SELECTED_EXECUTOR: // выбранный исполнитель
                $actions[] = self::ACTION_DENIAL; // отказаться
                break;
        }

        return $actions;
    }
}
