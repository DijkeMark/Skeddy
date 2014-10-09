<?php
App::uses('AppModel', 'Model');
/**
 * Role Model
 *
 * @property Job $Job
 */
class Role extends AppModel {

	public $hasMany = array(
		'Job' => array(
			'className' => 'Job',
			'foreignKey' => 'role_id'
		)
	);

}
