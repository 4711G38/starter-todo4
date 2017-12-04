<?php

/**
 * XML-persisted collection.
 *
 * @author		JLP
 * @copyright           Copyright (c) 2010-2017, James L. Parry
 * ------------------------------------------------------------------------
 */
class XML_Model extends Memory_Model
{
    //---------------------------------------------------------------------------
    //  Housekeeping methods
    //---------------------------------------------------------------------------

    /**
     * Constructor.
     * @param string $origin Filename of the XML file
     * @param string $keyfield  Name of the primary key field
     * @param string $entity	Entity name meaningful to the persistence
     */
    public function __construct($origin = null, $keyfield = 'id', $entity = null)
    {
        parent::__construct();

        // guess at persistent name if not specified
        if ($origin == null) {
            $this->_origin = get_class($this);
        } else {
            $this->_origin = $origin;
        }

        // remember the other constructor fields
        $this->_keyfield = $keyfield;
        $this->_entity = $entity;

        // start with an empty collection
        $this->_data = array(); // an array of objects
        $this->_fields = array(); // an array of strings
        // and populate the collection
        $this->load();
    }

    /**
     * Load the collection state appropriately, depending on persistence choice.
     * OVER-RIDE THIS METHOD in persistence choice implementations
     */
    protected function load()
    {
        if (file_exists('../data/tasks.xml')) {
            $xml = simplexml_load_file('../data/tasks.xml');

            $tasktiles = array();

            // get & store titles
            foreach ($xml->children()->children() as $column) {
                $tasktitles[] = $column->getName();
            }
            $this->_fields = $tasktitles;
            //print_r($this->_fields);

            // cast and store objects
            foreach ($xml->children() as $task) {
                $record = new stdClass();
                $record->id = (int) $task->id;
                $record->task = (string) $task->task;
                $record->priority = (int) $task->priority;
                $record->size = (int) $task->size;
                $record->group = (int) $task->group;
                $record->deadline = (int) $task->deadline;
                $record->status = (int) $task->status;
                $record->flag = (int) $task->flag;

                //$tasklist[] = $task;
                $key = $record->{$this->_keyfield};
                $this->_data[$key] = $record;
            }
        } else {
            exit('Failed to open tasks.xml.');
        }
        $this->reindex();
    }

    /**
     * Store the collection state appropriately, depending on persistence choice.
     * OVER-RIDE THIS METHOD in persistence choice implementations
     */
    protected function store()
    {
        // rebuild the keys table
        $this->reindex();

        $document = new DOMDocument('1.0', 'UTF-8');
				$tasks = $document->createElement('tasks');
				$document->appendChild($tasks);

				foreach ($this->_data as $key => $record) {
						$todo = $document->createElement('todo');
						$tasks->appendChild($todo);

						foreach($record as $keyname => $value) {
								$todo->appendChild($document->createElement($keyname, $value));
						}
				}

				$document->formatOutput = true;
        $document->save('../data/tasks.xml');
    }
}
