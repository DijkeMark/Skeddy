<?php
App::uses('AppModel', 'Model');
/**
 * Employer Model
 *
 * @property Job $Job
 * @property Role $Role
 * @property TimeScheduleItem $TimeScheduleItem
 */
class Employer extends AppModel {

	public $belongsTo = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_id'
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id'
		)
	);

	public $hasMany = array(
		'TimeScheduleItem' => array(
			'className' => 'TimeScheduleItem',
			'foreignKey' => 'employer_id'
		)
	);

	public function findEmployersByCompanyId($companyId)
	{
		$results = $this->find('all', array(
			'contain' => array(
				'Job' => array(
					'fields' => array(
						'id',
						'name'
					),
					'Company' => array(
						'fields' => array(
							'id',
							'name'
						)
					)
				)
			),
			'fields' => array(
				'id',
				'name',
				'insertion',
				'lastname',
				'profile_photo'
			),
			'conditions' => array(
				'Job.company_id' => $companyId
			)
		));

		return $results;
	}
}
