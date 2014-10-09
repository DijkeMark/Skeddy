<?php
App::uses('AppModel', 'Model');
/**
 * Employer Model
 *
 * @property TimeScheduleItem $TimeScheduleItem
 * @property Job $Job
 */
class Employer extends AppModel {

	public $hasMany = array(
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'foreignKey' => 'employer_id'
		)
	);
	
	public $hasAndBelongsToMany = array(
		'Job' => array(
			'className' => 'Job',
			'joinTable' => 'employers_jobs',
			'foreignKey' => 'employer_id',
			'associationForeignKey' => 'job_id'
		)
	);
}
