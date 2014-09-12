<?php
App::uses('AppModel', 'Model');
/**
 * Job Model
 *
 * @property Company $Company
 * @property Employer $Employer
 */
class Job extends AppModel {

	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id'
		)
	);

	public $hasMany = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'job_id'
		)
	);

}
