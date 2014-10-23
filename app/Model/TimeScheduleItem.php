<?php
App::uses('AppModel', 'Model');
/**
 * TimeScheduleItem Model
 *
 * @property Note $Note
 * @property Employer $Employer
 */
class TimeScheduleItem extends AppModel {

	public $hasMany = array(
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'time_schedule_item_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Employer' => array(
			'className' => 'Employer',
			'joinTable' => 'employers_time_schedule_items',
			'foreignKey' => 'time_schedule_item_id',
			'associationForeignKey' => 'employer_id'
		)
	);

	public function getItemsForWeek($companyId, $startDayOfWeek, $endDayOfWeek)
	{
		$results = $this->find('all', array(
			'contain' => array(
				'Employer' => array(
					'fields' => array(
						'id',
						'profile_photo'
					),
					'Job' => array(
						'Company' => array(
							'conditions' => array(
								'id' => $companyId
							)
						)
					)
				)
			),
			'conditions' => array(
				'date >=' => $startDayOfWeek,
				'date <=' => $endDayOfWeek
			)
		));

		return $results;
	}
}
