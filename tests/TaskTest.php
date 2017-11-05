<?php
include('../application/models/Task.php');

if (!class_exists('\PHPUnit_Framework_TestCase')) {
    class_alias('PHPUnit\Framework\TestCase','PHPUnit_Framework_TestCase');
}

class TaskTest extends PHPUnit_Framework_TestCase {
    private $task;
    // Runs everytime before each test
    public function setUp() {
        $this->task = new Task();
    }
    public function testTask() {
        $this->task->__set("task", "Make a new task");
        $this->assertEquals("Make a new task", $this->task->getTask());
    }
    public function testPriority() {
        $this->task->__set("priority", "1");
        $this->assertEquals("1", $this->task->getPriority());
    }
    public function testSize() {
        $this->task->__set("size", "3");
        $this->assertEquals("3", $this->task->getSize());
    }
    public function testGroup() {
        $this->task->__set("group", "4");
        $this->assertEquals("4", $this->task->getGroup());
    }
}
