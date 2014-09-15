<div id="login-container">
	<h1>Login</h1>
	<?php
		echo $this->Form->create('Employer');
		echo $this->Form->input('email', array('label' => false, 'placeholder' => 'Email'));
		echo $this->Form->input('password', array('label' => false, 'placeholder' => 'Password'));
		echo $this->Form->submit();
		echo $this->Form->end();
	?>
</div>