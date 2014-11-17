<?php
	echo $this->html->script(array('company/companyRegistration.js'), array('inline' => false));
?>
<div id='settings-container'>
	<div id='company-registration'>
		<h1>Company Registration</h1>
		<div id='error'></div>
		<?php
			echo $this->Form->create('Company', array('action' => 'registration'));
		?>
			<fieldset>
				<legend>Company Info</legend>
			<?php
				echo $this->Form->input('name');
				echo $this->Form->input('address');
				echo $this->Form->input('postcode');
				echo $this->Form->input('city');
				echo $this->Form->input('telephone');
				echo $this->Form->input('email');
			?>
			</fieldset>
			<fieldset>
				<legend>Owner Info</legend>
			<?php
				echo $this->Form->input('Employer.name');
				echo $this->Form->input('Employer.insertion');
				echo $this->Form->input('Employer.lastname');
				echo $this->Form->input('Employer.email');
				echo $this->Form->input('Employer.password');
				echo $this->Form->input('Employer.retype-password', array('type' => 'password'));
			?>
			</fieldset>
		<?php
			echo $this->Form->submit('Register', array('id' => 'register-company'));
			echo $this->Form->end();
		?>
	</div>
	<div id='registration-complete'>
		<p>Company registration complete. An email has been sent to you.</p>
		<p><?php echo $this->Html->link('Click Here', array('controller' => 'employers', 'action' => 'login')); ?> to go back to the login page.</p>
	</div>
</div>