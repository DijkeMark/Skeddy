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

	public $hasMany = array(
		'Note' => array(
			'className' => 'Note',
			'foreignKey' => 'time_schedule_item_id'
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
			'fields' => array(
				'id',
				'date'
			),
			'conditions' => array(
				'date >=' => $startDayOfWeek,
				'date <=' => $endDayOfWeek
			)
		));

		return $results;
	}
}
