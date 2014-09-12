<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property Employer $Employer
 */
class Role extends AppModel {
	
	public $hasMany = array(
		'Employer' => array(
			'className' => 'Employer',
			'foreignKey' => 'role_id'
		)
	);

}
