<div id='settings-container'>
	<h1>Settings</h1>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'companies', 'action' => 'invite')));
		echo $this->Form->input('email');
		echo $this->Form->hidden('company_id', array('value' => $companyId));
		echo $this->Form->submit();
		echo $this->Form->end();
	?>
</div>