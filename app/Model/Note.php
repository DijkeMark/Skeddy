<?php
App::uses('AppModel', 'Model');
/**
 * Note Model
 *
 * @property TimeScheduleItem $TimeScheduleItem
 */
class Note extends AppModel {
	
	public $belongsTo = array(
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'foreignKey' => 'time_schedule_item_id'
		)
	);
}
