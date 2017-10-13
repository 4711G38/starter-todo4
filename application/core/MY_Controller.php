<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		JLP
 * @copyright           2010-2016, James L. Parry
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller
{

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */

	function __construct()
	{
		parent::__construct();

		//  Set basic view parameters
		$this->data = array ();
		$this->data['pagetitle'] = 'G38 - Lab 5';
		$this->data['ci_version'] = (ENVIRONMENT === 'development') ? 'CodeIgniter Version <strong>'.CI_VERSION.'</strong>' : '';
        
        
        $tasks = $this->tasks->all();   // get all the tasks

        // count how many are not done
        $count = 0;
        foreach($tasks as $task) {
                if ($task->status != 2) $count++;
        }
        // and save that as a view parameter
        $this->data['remaining_tasks'] = $count;
        
        // process the array in reverse, until we have five
        $count = 0;
        foreach(array_reverse($tasks) as $task) {
        $task->priority = $this->app->priority($task->priority);
        $display_tasks[] = (array) $task;
            $count++;
            if ($count >= 5) break;
        }
        $this->data['display_tasks'] = $display_tasks;
	}

	/**
	 * Render this page
	 */
    function render($template = 'template')
    {
        $this->data['menubar'] = $this->parser->parse('_menubar', $this->config->item('menu_choices'),true);
        // use layout content if provided
        if (!isset($this->data['content']))
            $this->data['content'] = $this->parser->parse($this->data['pagebody'], $this->data, true);
        $this->parser->parse($template, $this->data);

    }

}
