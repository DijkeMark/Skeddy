<div id='topbar'>
	<div id='navigation'>
		<div class='icon left' id='l-sb-btn'>
			<i class="fa fa-calendar"></i>
		</div>

		<div class='icon left' id='previous'>
			<i class="fa fa-angle-left"></i>
		</div>

		<div class='icon left' id='next'>
			<i class="fa fa-angle-right"></i>
		</div>

		<div class='icon left' id='today'>
			<i class="fa fa-th-list"></i>
		</div>

		<div class='icon left'>
			<?php echo $this->Html->link('Overview', array('controller' => 'schedules', 'action' => 'overview')); ?>
		</div>
		<div class='icon left'>
			<?php echo $this->Html->link('Settings', array('controller' => 'employers', 'action' => 'settings')); ?>
		</div>
		<div class='icon left'>
			<?php echo $this->Html->link('Invite', array('controller' => 'companies', 'action' => 'invite')); ?>
		</div>

		<?php
		if(isset($teamMembers))
		{
		?>
			<div class='icon right' id='r-sb-btn'>
				<i class="fa fa-users"></i>
			</div>
		<?php
		}
		?>
	</div>

	<div id='date'>
		Month <span id='year'>Year</span>
	</div>
</div>