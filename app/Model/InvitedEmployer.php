<?php
App::uses('AppModel', 'Model');
/**
 * InvitedEmployer Model
 *
 * @property Company $Company
 */
class InvitedEmployer extends AppModel {

	public $belongsTo = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'company_id'
		)
	);
}
