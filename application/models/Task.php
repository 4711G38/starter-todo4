<?php
include('../application/core/Entity.php');

class Task extends Entity
{
    private $task;
    private $priority;
    private $size;
    private $group;
    private $flag;
    private $deadline;

    public function setTask($task)
    {
        if (strlen($task) <= 64 && strlen($task) > 0) {
            $this->task = $task;
        }
    }
    public function setPriority($priority)
    {
        if ($priority > 0 && $priority < 4) {
            $this->priority = $priority;
        }
    }
    public function setSize($size)
    {
        if ($size > 0 && $size < 4) {
            $this->size = $size;
        }
    }
    public function setGroup($group)
    {
        if ($group > 0 && $group < 5) {
            $this->group = $group;
        }
    }
    public function setFlag($flag)
    {
        if ($flag > 0 & $flag <= 1) {
            $this->flag = $flag;
        }
    }
    public function setDeadline($deadline)
    {
        $this->deadline = $deadline;
    }


    // If this class has a setProp method, use it, else modify the property directly
    public function __set($key, $value)
    {
        // if a set* method exists for this key,
        // use that method to insert this value.
        // For instance, setName(...) will be invoked by $object->name = ...
        // and setLastName(...) for $object->last_name =
        $method = 'set' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
        if (method_exists($this, $method)) {
            $this->$method($value);
            return $this;
        }
        // Otherwise, just set the property value directly.
        $this->$key = $value;
        return $this;
    }

    public function __get($key)
    {
        // if a get* method exists for this key,
        // use that method to get this value.
        $method = 'get' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $key)));
        if (method_exists($this, $method)) {
            return $this->$method();
        }
        // Otherwise, just return null
        return $this->$key;
    }
}
