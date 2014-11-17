<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');
App::uses('CakeEmail', 'Network/Email');

class CompaniesController extends AppController {

	public $uses = array('InvitedEmployer', 'Employer', 'Company', 'Job', 'JobDescription', 'Role');

	public function beforeFilter()
	{
		parent::beforeFilter();

		$this->Auth->allow('registration');
	}

	public function registration()
	{
		if($this->request->is('post'))
	    {
	    	$this->autoRender = false;
	    	$this->layout = 'ajax';

	    	$jsonData['response']['errors'] = array();
	    	$this->registerCompany($jsonData, $this->request->data['Company']);
	    }
	    else
	    {
	    	$this->layout = 'settings';
	    }
	}

	private function registerCompany($jsonData, $company)
	{
		$existingCompaniesWithEmail = $this->Company->findAllByEmail($company['email']);

		if(count($existingCompaniesWithEmail) == 0)
		{
			if($this->Company->save($company))
			{
				$jsonData['companyId'] = $this->Company->getLastInsertID();
				$this->registerDirector($jsonData, $this->request->data['Employer']);
			}
			else
			{
				array_push($jsonData['response']['errors'], 'An error occured while processing your company registration. Please try again.');
			}
		}
		else
		{
			array_push($jsonData['response']['errors'], 'Your company email is already in use. Please enter another email.');
		}

		if(count($jsonData['response']['errors']) > 0)
		{
			echo json_encode($jsonData['response']);
		}
	}

	private function registerDirector($jsonData, $user)
	{
		$existingUserWithEmail = $this->Employer->findAllByEmail($user['email']);

		if(count($existingUserWithEmail) == 0)
		{
			if($user['password'] == $user['retype-password'])
			{
				Security::setHash('blowfish');
				$user['password'] = Security::hash($user['password']);
				if($this->Employer->save($user))
				{
					$jsonData['userId'] = $this->Employer->getLastInsertID();
					$this->createDirectorsJob($jsonData);
				}
				else
				{
					$this->Company->delete($jsonData['companyId']);
					array_push($jsonData['response']['errors'], 'An error occured while processing your company registration. Please try again.');
				}
			}
			else
			{
				array_push($jsonData['response']['errors'], 'Your passwords are not the same.');
			}
		}
		else
		{
			array_push($jsonData['response']['errors'], 'Your email is already in use. Please enter another email.');
		}

		if(count($jsonData['response']['errors']) > 0)
		{
			echo json_encode($jsonData['response']);
		}
	}

	private function createDirectorsJob($jsonData)
	{
		$directorRoleId = $this->Role->findByRights(1)['Role']['id'];
		
		$jobDescription['JobDescription']['name'] = 'Director';
		$jobDescription['JobDescription']['company_id'] = $jsonData['companyId'];

		if($this->JobDescription->save($jobDescription))
		{
			$jobDescriptionId = $this->JobDescription->getLastInsertID();

			$job['Job']['employer_id'] = $jsonData['userId'];
			$job['Job']['job_description_id'] = $jobDescriptionId;
			$job['Job']['role_id'] = $directorRoleId;

			if($this->Job->save($job))
			{
				$this->companyRegistrationComplete($jsonData);
			}
			else
			{
				$this->Company->delete($jsonData['companyId']);
				$this->Employer->delete($jsonData['userId']);
				$this->JobDescription->delete($jobDescriptionId);
				array_push($jsonData['response']['errors'], 'An error occured while processing your company registration. Please try again.');
			}
		}
		else
		{
			$this->Company->delete($jsonData['companyId']);
			$this->Employer->delete($jsonData['userId']);
			array_push($jsonData['response']['errors'], 'An error occured while processing your company registration. Please try again.');
		}

		if(count($jsonData['response']['errors']) > 0)
		{
			echo json_encode($jsonData['response']);
		}
	}

	private function companyRegistrationComplete($jsonData)
	{
		$email = new CakeEmail('mandrill');
    	$email->template('CompanyRegistration');
    	$email->to($this->request->data['Employer']['email']);
    	$email->subject('Skeddy Company Registration');
    	$email->viewVars(array(
    		'email' => $this->request->data['Employer']['email'],
    		'password' => $this->request->data['Employer']['password']
    	));

    	if($email->send()[0]['status'] == 'sent')
    	{
    		echo json_encode($jsonData['response']);
    	}
	}

	public function invite()
	{
		$companyId = $this->getJobInfo($this->getEmployerId())['Job']['company_id'];

		if(empty($this->request->data))
		{
			$this->layout = 'settings';

			$data['companyId'] = $companyId;
			$data['invitedEmployers'] = $this->InvitedEmployer->findInvitedEmployersByCompanyId($companyId);
			$this->set($data);
		}
		else if($this->request->is('post'))
	    {
	    	$this->autoRender = false;
	    	$jsonData = array();

	    	if(count($this->InvitedEmployer->findAllByEmail($this->request->data['InvitedEmployer']['email'])) == 0
	    		&& count($this->Employer->findAllByEmail($this->request->data['InvitedEmployer']['email'])) == 0)
	    	{
	            $this->request->data['InvitedEmployer']['invitation_code'] = $this->generateInvitationCode();

	            if($this->InvitedEmployer->save($this->request->data))
	            {
	            	$company = $this->Company->findById($companyId);

	            	$email = new CakeEmail('mandrill');
	            	$email->template('InviteEmployer');
	            	$email->to($this->request->data['InvitedEmployer']['email']);
	            	$email->subject('Skeddy Registration Invite');
	            	$email->viewVars(array(
	            		'company' => $company['Company']['name'],
	            		'url' => 'skeddy.dev/employers/registration/'.$this->request->data['InvitedEmployer']['invitation_code']
	            	));

	            	if($email->send()[0]['status'] == 'sent')
	            	{
	            		$inviteId = $this->InvitedEmployer->getLastInsertID();
	            		$invite = $this->InvitedEmployer->findById($inviteId);
	            		$invite['InvitedEmployer']['invite_send'] = 1;

	            		$this->InvitedEmployer->save($invite);
	            	}
	            }
	            else
	            {
	            	$jsonData['Error'] = 'An error occured while saving this invite. Please try again later.';
	            }
	        }
	        else
	        {
	        	$jsonData['Error'] = 'This email has already been invited.';
	        }

            $jsonData['InvitedEmployers'] = $this->InvitedEmployer->findInvitedEmployersByCompanyId($companyId);

            echo json_encode($jsonData);
	    }
	}

	private function generateInvitationCode()
	{
		$allowedCodeChars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
			'1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
		$codeUnique = false;
		$invitationCode = '';

		while(!$codeUnique)
		{
			for($i = 0; $i < 10; $i++)
			{
				$invitationCode .= $allowedCodeChars[rand(0, count($allowedCodeChars) - 1)];
			}

			$results = $this->InvitedEmployer->findByInvitationCode($invitationCode);
			if(count($results) == 0)
			{
				$codeUnique = true;
			}
			else
			{
				$invitationCode = '';
			}
		}

		return $invitationCode;
	}
}