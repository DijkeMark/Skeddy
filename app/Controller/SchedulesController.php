<?php
App::uses('AppController', 'Controller');
/**
 * Schedular Controller
 *
 * @property Employer $Employer
 */
class SchedulesController extends AppController {

	public $layoutToUse = 'schedule';

	public function index()
	{
		$this->redirect(array('controller' => 'schedules', 'action' => 'overview'));
	}

	public function overview()
	{
		$this->layout = $this->layoutToUse;
	}
}
