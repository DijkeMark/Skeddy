<?php
App::uses('AppModel', 'Model');
/**
 * Job Model
 *
 * @property Employer $Employer
 * @property JobDescription $JobDescription
 * @property Role $Role
 */
class Job extends AppModel {

	public $belongsTo = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'employer_id'
		),
		'JobDescription' => array(
			'className' => 'JobDescription',
			'foreignKey' => 'job_description_id'
		),
		'Role' => array(
			'className' => 'Role',
			'foreignKey' => 'role_id'
		)
	);
}
