<?php
App::uses('AppModel', 'Model');
/**
 * Company Model
 *
 * @property InvitedEmployer $InvitedEmployer
 * @property Job $Job
 */
class Company extends AppModel {

	public $hasMany = array(
		'InvitedEmployer' => array(
			'className' => 'InvitedEmployer',
			'foreignKey' => 'company_id'
		),
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'company_id'
		)
	);

}
