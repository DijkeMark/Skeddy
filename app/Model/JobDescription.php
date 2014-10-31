<?php
App::uses('AppModel', 'Model');
/**
 * JobDescription Model
 *
 * @property Company $Company
 * @property Job $Job
 */
class JobDescription extends AppModel {

	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id'
		)
	);
	
	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'job_description_id'
		)
	);

}
