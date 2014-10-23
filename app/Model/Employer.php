<?php
App::uses('AppModel', 'Model');
/**
 * Employer Model
 *
 * @property Job $Job
 * @property TimeScheduleItem $TimeScheduleItem
 */
class Employer extends AppModel {

	public $hasAndBelongsToMany = array(
		'Job' => array(
			'className' => 'Job',
			'joinTable' => 'employers_jobs',
			'foreignKey' => 'employer_id',
			'associationForeignKey' => 'job_id'
		),
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'joinTable' => 'employers_time_schedule_items',
			'foreignKey' => 'employer_id',
			'associationForeignKey' => 'time_schedule_item_id'
		)
	);
}
