<?php
App::uses('AppModel', 'Model');
/**
 * EmployersJob Model
 *
 * @property Employer $Employer
 * @property Job $Job
 */
class EmployersJob extends AppModel {

	public $belongsTo = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'employer_id'
		),
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_id'
		)
	);
}
