<?php

use PHPUnit\Framework\TestCase;

class TaskListTest extends TestCase {

    private $codeIgniter;

    public function setUp() {
        $this->codeIgniter = &get_instance();
    }

    public function testUncompletedTasksGreaterThanCompleted() {
        $allTasks = (new Tasks()) -> all();

        $completedTaskCount = 0;
        foreach ($allTasks as $task) {
            if ($task->status == 2) {
                $completedTaskCount++;
            }
        }

        $uncompletedTaskCount = count($allTasks) - $completedTaskCount;

        $this->assertGreaterThan($uncompletedTaskCount, $completedTaskCount);
    }

}
