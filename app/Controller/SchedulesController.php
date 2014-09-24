<?php
App::uses('AppController', 'Controller');
/**
 * Schedular Controller
 *
 * @property Employer $Employer
 */
class SchedulesController extends AppController {

	public $uses = array('Employer', 'TimeScheduleItem');

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

	public function addNewItemToRoster()
	{
		$this->autoRender = false;

		if($this->request->is('post'))
		{
			$data = array();
			$data['TimeScheduleItem'] = array(
				'date' => $this->request->data['date'],
				'employer_id' => $this->request->data['employerId']
			);

			if($this->TimeScheduleItem->save($data))
			{
	            echo 'saved succesfully';
	        }
	        else
	        {
	        	echo 'save failed';
	        }
		}
		else
		{
			$this->response->statusCode('403');
		}
	}
}
