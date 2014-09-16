<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
/**
 * Employers Controller
 *
 * @property Employer $Employer
 */
class EmployersController extends AppController {

	public $helpers = array('Form');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('login');
	}

	public function login()
	{
		$layout = 'login';
		$this->layout = $layout;

		if($this->request->is('post'))
		{
			if($this->Auth->login())
			{
	            return $this->redirect($this->Auth->redirectUrl());
	        }
	        else
	        {
                $this->Session->setFlash('Your username or password was incorrect.');
            }
		}
	}
}
