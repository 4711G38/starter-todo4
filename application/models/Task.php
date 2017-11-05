<?php
include('../application/core/Entity.php');

class Task extends Entity {
    private $task;
    private $priority;
    private $size;
    private $group;
    public function setTask($task) {
        if (strlen($task) <= 64 && strlen($task) > 0)
            $this->task = $task;
    }
    public function setPriority($priority) {
        if ($priority > 0 && $priority < 4)
            $this->priority = $priority;
    }
    public function setSize($size) {
        if ($size > 0 && $size < 4)
            $this->size = $size;
    }
    public function setGroup($group) {
        if ($group > 0 && $group < 5)
            $this->group = $group;
    }
    public function getTask() {
        return $this->task;
    }
    public function getPriority() {
        return $this->priority;
    }
    public function getSize() {
        return $this->size;
    }
    public function getGroup() {
        return $this->group;
    }
}