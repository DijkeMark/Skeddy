<div id='settings-container'>
	<h1>Settings</h1>
	<?php
		if($this->Session->read('Auth.User.registration_complete') == 0)
		{
			echo 'Complete your registration by entering your information';
		}

		echo $this->Form->create('Employer', array('action' => 'settings'));
		echo $this->Form->input('name');
		echo $this->Form->input('insertion');
		echo $this->Form->input('lastname');
		echo $this->Form->input('address');
		echo $this->Form->input('postcode');
		echo $this->Form->input('city');
		echo $this->Form->input('telephone_home');
		echo $this->Form->input('telephone_smartphone');
		echo $this->Form->input('email');
		echo $this->Form->hidden('id');
		echo $this->Form->hidden('registration_complete', array('value' => 1));
		echo $this->Form->submit();
		echo $this->Form->end();
	?>
</div>