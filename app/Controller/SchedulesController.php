<?php
App::uses('AppController', 'Controller');
/**
 * Schedular Controller
 *
 * @property Employer $Employer
 */
class SchedulesController extends AppController {

	public $uses = array('Employer');

	public $layoutToUse = 'schedule';

	public function index()
	{
		$this->redirect(array('controller' => 'schedules', 'action' => 'overview'));
	}

	public function overview()
	{
		$this->layout = $this->layoutToUse;

		$data = array();
		if($this->hasAccess(1))
		{
			$data['teamMembers'] = $this->getTeamMembers();
		}

		$this->set($data);
	}

	private function getTeamMembers()
	{
		$companyId = $this->Session->read('Auth.User.Job.company_id');
		return $this->Employer->findEmployersByCompanyId($companyId);
	}
}
