<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Views extends Application
{

	/**
   *
	 */
	public function index()
	{
    $this->data['pagetitle'] = 'Ordered TODO List';
    $tasks = $this->tasks->all();   // get all the tasks
    $this->data['content'] = 'Ok'; // so we don't need pagebody
    $this->data['leftside'] = $this->makePrioritizedPanel($tasks);
    $this->data['rightside'] = $this->makeCategorizedPanel($tasks);
    $this->render('template_secondary');
	}

	function makePrioritizedPanel($tasks)
	{
			// Extract all undone tasks to be prioritized.
			foreach ($tasks as $task)
			{
					if ($task->status != 2)
					{
							$undone[] = $task;
					}
			}

			// order them by priority
			usort($undone, "orderByPriority");

			// substitute the priority name
			foreach ($undone as $task)
			{
					$task->priority = $this->app->priority($task->priority);
			}

			// convert the array of task objects into an array of associative objects
			foreach ($undone as $task)
			{
					$converted[] = (array)$task;
			}

			$params = ['display_tasks' => $converted];
            // INSERT the next two lines
            $role = $this->session->userdata('userrole');
            $params['completer'] = ($role == ROLE_OWNER) ? '/views/complete' : '#';
			return $this->parser->parse('by_priority', $params, true);
	}

	function makeCategorizedPanel($tasks)
	{
		$params = ['display_tasks' => $this->tasks->getCategorizedTasks()];
		return $this->parser->parse('by_category', $params, true);
	}
    
    // complete flagged items
    function complete() {
        $role = $this->session->userdata('userrole');
        if ($role != ROLE_OWNER) redirect('/work');

        // loop over the post fields, looking for flagged tasks
        foreach($this->input->post() as $key=>$value) {
            if (substr($key,0,4) == 'task') {
                // find the associated task
                $taskid = substr($key,4);
                $task = $this->tasks->get($taskid);
                $task->status = 2; // complete
                $this->tasks->update($task);
            }
        }
        $this->index();
    }

}

function orderByPriority($a, $b)
{
		if($a->priority > $b->priority) {
			return -1;
		} else if ($a->priority < $b->priority) {
			return 1;
		}
		return 0;
}