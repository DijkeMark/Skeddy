<?php
App::uses('AppModel', 'Model');
/**
 * EmployersTimeScheduleItem Model
 *
 * @property Employer $Employer
 * @property TimeScheduleItem $TimeScheduleItem
 */
class EmployersTimeScheduleItem extends AppModel {

	public $belongsTo = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'employer_id'
		),
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'foreignKey' => 'time_schedule_item_id'
		)
	);
}
