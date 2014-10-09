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

	public function findEmployersByCompanyId($companyId)
	{
		$results = $this->find('all', array(
			'contain' => array(
				'Job' => array(
					'fields' => array(
						'id',
						'name'
					),
					'Employer' => array(
						'fields' => array(
							'id',
							'name',
							'insertion',
							'lastname',
							'profile_photo'
						)
					)
				)
			),
			'fields' => array(
				'id'
			),
			'conditions' => array(
				'Company.id' => $companyId
			)
		));

		$employers = array();
		foreach($results as $result)
		{
			for($i = 0; $i < count($result['Job']); $i++)
			{ 
				$job = $result['Job'][$i];

				for($a = 0; $a < count($job['Employer']); $a++)
				{
					$employer['Employer'] = $job['Employer'][$a];
					$employer['Job']['id'] = $job['id'];
					$employer['Job']['company_id'] = $job['company_id'];
					$employer['Job']['name'] = $job['name'];

					array_push($employers, $employer);
				}
			}
		}

		return $employers;
	}
}
