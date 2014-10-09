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

		$this->Auth->allow('login', 'logout', 'registration');
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
                $this->Session->setFlash('Your username or password is incorrect.');
            }
		}
		elseif($this->Auth->loggedIn())
		{
			return $this->redirect($this->Auth->redirectUrl());
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}

	public function settings()
	{
		$layout = 'settings';
		$this->layout = $layout;

		if(empty($this->request->data))
		{
			$userId = $this->Session->read('Auth.User.id');
	        $this->request->data = $this->Employer->findById($userId);
	    }
	    else if($this->request->is('post'))
	    {
            if($this->Employer->save($this->request->data))
            {
            	echo 'saved';
            }
	    }
	}

	public function registration()
	{
		$layout = 'settings';
		$this->layout = $layout;

	  	if($this->request->is('post'))
	    {
            if($this->Employer->save($this->request->data))
            {
            	echo 'saved';
            }
	    }
	}
}
