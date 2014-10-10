<div id='settings-container'>
	<h1>Registration</h1>
	<div id='error'><?php if(isset($error)) { echo $error; } ?></div>
	<?php
		echo $this->Form->create('Employer', array('action' => 'registration/'.$this->request->data['Employer']['invitation_code']));
		echo $this->Form->input('email', array('disabled' => true, 'value' => $this->request->data['Employer']['email']));
		echo $this->Form->input('first_password', array('label' => 'Password', 'type' => 'password', 'default' => ''));
		echo $this->Form->input('retype_password', array('type' => 'password', 'default' => ''));
		echo $this->Form->input('invitation_code', array('disabled' => true));
		echo $this->Form->hidden('email', array('value' => $this->request->data['Employer']['email']));
		echo $this->Form->hidden('invitation_code', array('value' => $this->request->data['Employer']['invitation_code']));
		echo $this->Form->hidden('invite_id', array('value' => $this->request->data['Employer']['invite_id']));
		echo $this->Form->submit('Register');
		echo $this->Form->end();
	?>
</div>