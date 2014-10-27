<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');
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
            	$this->Session->write('Auth.User.registration_complete', 1);
            }
	    }
	}

	public function setProfilePicture()
	{
		$this->autoRender = false;
		$this->layout = 'ajax';

		$picture = $this->request->data['Employer']['upload-field'];
		$allowedFormats = array(
			'image/jpeg' => 'jpg',
			'image/png' => 'png'
		);

		if($picture['error'] == 0 && array_key_exists($picture['type'], $allowedFormats))
	    {
	    	$employerId = $this->getEmployerId();

	    	$file = new File($picture['tmp_name']);

	    	if($file->exists())
	    	{
	    		$fileNameOnServer = md5($picture['name']).time().'.'.$allowedFormats[$picture['type']];

				$dir = new Folder('img/employers', true);
				if($file->copy($dir->path.DS.$fileNameOnServer))
				{
					$oldFile = new File($dir->path.DS.$this->Session->read('Auth.User.profile_photo'));

					if($oldFile->delete())
					{
						$data['Employer']['id'] = $employerId;
						$data['Employer']['profile_photo'] = $fileNameOnServer;

						if($this->Employer->save($data))
						{
							$this->Session->write('Auth.User.profile_photo', $fileNameOnServer);
						}
					}
				}
			}
	    }

	    $jsonData['profile_photo'] = $this->Session->read('Auth.User.profile_photo');
	    echo json_encode($jsonData);
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

		            	$email = new CakeEmail('mandrill');
		            	$email->template('EmployerRegistration');
		            	$email->to($this->request->data['Employer']['email']);
		            	$email->subject('Skeddy Registration');
		            	$email->viewVars(array(
		            		'email' => $this->request->data['Employer']['email'],
		            		'password' => $this->request->data['Employer']['first_password']
		            	));
		            	$email->send();

						$this->redirect(array('controller' => 'employers', 'action' => 'login'));
		            }
		    	}
		    	else
		    	{
		    		$this->Session->setFlash('Passwords do not match.');
		    	}
		    }
		    else
		    {
		    	$this->Session->setFlash('Please enter all password fields.');
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
