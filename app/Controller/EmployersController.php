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

	public $uses = array('InvitedEmployer', 'Employer');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('login', 'logout', 'registration');
	}

	public function login()
	{
		$this->layout = 'login';

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
		$this->layout = 'settings';

		if(empty($this->request->data))
		{
	        $this->request->data = $this->Employer->findById($this->getEmployerId());
	    }
	    else if($this->request->is('post'))
	    {
            if($this->Employer->save($this->request->data))
            {
            	echo 'saved';
            }
	    }
	}

	public function registration($invitationCode)
	{
		$this->layout = 'settings';

		if($this->request->is('post'))
	    {
	    	if(!is_null($this->request->data['Employer']['first_password']) && !is_null($this->request->data['Employer']['retype_password'])
	    		&& $this->request->data['Employer']['first_password'] != '' && $this->request->data['Employer']['retype_password'] != '')
	    	{
		    	if($this->request->data['Employer']['first_password'] == $this->request->data['Employer']['retype_password'])
		    	{
		    		Security::setHash('blowfish');
		    		$this->request->data['Employer']['password'] = Security::hash($this->request->data['Employer']['first_password']);
		    		if($this->Employer->save($this->request->data))
		            {
		            	$this->InvitedEmployer->delete($this->request->data['Employer']['invite_id']);

		            	//Send mail for completing registration
		            	

		            	//Login and redirect to settings
		            }
		    	}
		    	else
		    	{
		    		$data['error'] = 'Passwords do not match';
		    		$this->set($data);
		    	}
		    }
		    else
		    {
		    	$data['error'] = 'Please enter all password fields';
		    	$this->set($data);
		    }
	    }
	    else
	    {
	    	if($invitationCode == null)
	    	{
	    		$this->logout();
	    	}
	    	else
	    	{
	    		$invite = $this->InvitedEmployer->findByInvitationCode($invitationCode);

	    		if(count($invite) > 0)
	    		{
	    			$this->request->data['Employer']['email'] = $invite['InvitedEmployer']['email'];
	    			$this->request->data['Employer']['invitation_code'] = $invite['InvitedEmployer']['invitation_code'];
	    			$this->request->data['Employer']['invite_id'] = $invite['InvitedEmployer']['id'];
	    		}
	    		else
	    		{
	    			$this->logout();
	    		}
	    	}
	    }
	}
}
