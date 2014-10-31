<?php
App::uses('AppModel', 'Model');
/**
 * Employer Model
 *
 * @property Job $Job
 * @property TimeScheduleItem $TimeScheduleItem
 */
class Employer extends AppModel {

	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'employer_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'joinTable' => 'employers_time_schedule_items',
			'foreignKey' => 'employer_id',
			'associationForeignKey' => 'time_schedule_item_id'
		)
	);

}
