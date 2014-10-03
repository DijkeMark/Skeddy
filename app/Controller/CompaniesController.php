<?php
App::uses('AppController', 'Controller');

class CompaniesController extends AppController {

	public $uses = array('InvitedEmployer');

	public function invite()
	{
		$companyId = $this->Session->read('Auth.User.Job.company_id');

		if(empty($this->request->data))
		{
			$layout = 'settings';
			$this->layout = $layout;

			$data['companyId'] = $companyId;
			$this->set($data);
		}
		else if($this->request->is('post'))
	    {
	    	$this->autoRender = false;
	    	$jsonData = array();

	    	if(count($this->InvitedEmployer->findAllByEmail($this->request->data['InvitedEmployer']['email'])) == 0)
	    	{
	            $this->request->data['InvitedEmployer']['invitation_code'] = $this->generateInvitationCode();

	            if(!$this->InvitedEmployer->save($this->request->data))
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
		$allowedCodeChars = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's','t', 'u', 'v', 'w', 'x', 'y', 'z',
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