<?php
App::uses('AppController', 'Controller');
/**
 * Schedular Controller
 *
 * @property Employer $Employer
 */
class SchedulesController extends AppController {

	public $uses = array('Company', 'EmployersJob', 'TimeScheduleItem');

	public $layoutToUse = 'schedule';

	public function index()
	{
		$this->redirect(array('controller' => 'schedules', 'action' => 'overview'));
	}

	public function overview()
	{
		$this->layout = $this->layoutToUse;

		$data = array();
		$employerId = $this->Session->read('Auth.User.id');
		$currentJobId = 3;
		$jobs = $this->EmployersJob->findAllByEmployerId($employerId);

		for($i = 0; $i < count($jobs); $i++)
		{
			if($jobs[$i]['Job']['id'] == $currentJobId && $this->hasAccess(3, $jobs[$i]['Job']['role_id']))
			{
				$data['teamMembers'] = $this->Company->findEmployersByCompanyId($jobs[$i]['Job']['company_id']);
			}	
		}

		$this->set($data);
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
			
			$this->TimeScheduleItem->save($data);

			return json_encode($this->findCorrectScheduleItems());
		}
		else
		{
			$this->response->statusCode('403');
		}
	}

	public function getScheduleItems()
	{
		$this->autoRender = false;

		if($this->request->is('post'))
		{
			return json_encode($this->findCorrectScheduleItems());
		}
		else
		{
			$this->response->statusCode('403');
		}
	}

	private function findCorrectScheduleItems()
	{
		$jsonData = array();

		switch($this->request->data['scheduleType'])
		{
			case 'weekly':
				$jsonData['ScheduleItems'] = $this->GetScheduleItemsForWeek();
				break;
			default:
				break;
		}

		return $jsonData;
	}

	private function GetScheduleItemsForWeek()
	{
		$companyId = 0;
		$employerId = $this->Session->read('Auth.User.id');
		$startDayOfWeek = $this->request->data['startDayOfWeek'];
		$endDayOfWeek = $this->request->data['endDayOfWeek'];

		$currentJobId = 3;
		$jobs = $this->EmployersJob->findAllByEmployerId($employerId);

		for($i = 0; $i < count($jobs); $i++)
		{
			if($jobs[$i]['Job']['id'] == $currentJobId && $this->hasAccess(3, $jobs[$i]['Job']['role_id']))
			{
				$companyId = $jobs[$i]['Job']['company_id'];
			}	
		}

		return $this->TimeScheduleItem->getItemsForWeek($companyId, $startDayOfWeek, $endDayOfWeek);
	}
}
