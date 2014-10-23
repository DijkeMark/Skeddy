<?php
App::uses('AppController', 'Controller');
/**
 * Schedular Controller
 *
 * @property Employer $Employer
 */
class SchedulesController extends AppController {

	public $uses = array('Company', 'EmployersJob', 'TimeScheduleItem', 'EmployersTimeScheduleItem');

	public function index()
	{
		$this->redirect(array('controller' => 'schedules', 'action' => 'overview'));
	}

	public function overview()
	{
		$this->layout = 'schedule';

		$data = array();

		$job = $this->getJobInfo($this->getEmployerId());
		
		if($this->hasAccess(3, $job['Job']['role_id']))
		{
			$data['teamMembers'] = $this->Company->findEmployersByCompanyId($job['Job']['company_id']);	
		}

		$this->set($data);
	}

	public function addNewItemToRoster()
	{
		$this->autoRender = false;

		if($this->request->is('post'))
		{
			$item['TimeScheduleItem'] = $this->request->data['TimeScheduleItem'];
			$item['TimeScheduleItem']['date'] = $item['TimeScheduleItem']['datepicker'];
			$item['TimeScheduleItem']['start_minute'] = $item['TimeScheduleItem']['start_minute'] * 5;
			$item['TimeScheduleItem']['end_minute'] = $item['TimeScheduleItem']['end_minute'] * 5;

			if($this->TimeScheduleItem->save($item))
			{
				$data['EmployersTimeScheduleItem']['employer_id'] = $this->request->data['employerId'];
				$data['EmployersTimeScheduleItem']['time_schedule_item_id'] = $this->TimeScheduleItem->getLastInsertID();

				$this->EmployersTimeScheduleItem->save($data);
			}

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
		$employerId = $this->Session->read('Auth.User.id');
		$startDayOfWeek = $this->request->data['startDayOfWeek'];
		$endDayOfWeek = $this->request->data['endDayOfWeek'];
		$companyId = 0;

		$job = $this->getJobInfo($this->getEmployerId());

		if($this->hasAccess(3, $job['Job']['role_id']))
		{
			$companyId = $job['Job']['company_id'];
		}

		return $this->TimeScheduleItem->getItemsForWeek($companyId, $startDayOfWeek, $endDayOfWeek);
	}

	public function loadNewScheduleElement()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		$this->render('/elements/new-schedule');
	}
}
