<?php
App::uses('AppModel', 'Model');
/**
 * Job Model
 *
 * @property Company $Company
 * @property Role $Role
 * @property Employer $Employer
 */
class Job extends AppModel {

	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id'
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id'
		)
	);

	public $hasAndBelongsToMany = array(
		'Employer' => array(
			'className' => 'Employer',
			'joinTable' => 'employers_jobs',
			'foreignKey' => 'job_id',
			'associationForeignKey' => 'employer_id'
		)
	);

}
