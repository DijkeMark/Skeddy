<?php
App::uses('AppModel', 'Model');
/**
 * TimeScheduleItem Model
 *
 * @property Employer $Employer
 * @property Note $Note
 */
class TimeScheduleItem extends AppModel {

	public $belongsTo = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'employer_id'
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'time_schedule_item_id'
		)
	);

}
