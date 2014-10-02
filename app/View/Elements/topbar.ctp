<div id='topbar'>
	<div id='navigation'>
		<div id='previous' class='left'>
			<i class="fa fa-angle-left"></i>
		</div>
		<div id='next' class='left'>
			<i class="fa fa-angle-right"></i>
		</div>
		<div class="left">
			<?php echo $this->Html->link('Overview', array('controller' => 'schedules', 'action' => 'overview')); ?>
		</div>
		<div class="left">
			<?php echo $this->Html->link('Settings', array('controller' => 'employers', 'action' => 'settings')); ?>
		</div>
		<div class="left">
			<?php echo $this->Html->link('Invite', array('controller' => 'companies', 'action' => 'invite')); ?>
		</div>
	</div>

	<div id='date'>
		Month <span id='year'>Year</span>
	</div>
</div>