<div id='new-schedule'>
	<div id="top">
		<div id='close'>
			<i class="fa fa-times"></i>
		</div>
		<div id='title'>New Schedule</div>
	</div>
	<div id='schedule-options'>
	<?php
		$hours = array('00', '01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12', '13', '14', '15', '16', '17', '18', '19', '20', '21', '22', '23', '24');
		$minutes = array('00', '05', '10', '15', '20', '25', '30', '35', '40', '45', '50', '55');

		echo $this->Form->create('TimeScheduleItem');
		echo $this->Form->input('name');
		echo $this->Form->input('datepicker', array('id' => 'datepicker', 'label' => 'Date'));
		echo $this->Form->input('start_hour', array(
		    'options' => $hours,
		    'empty' => 'Hour',
		    'label' => 'Start Time',
		    'div' => array(
		    	'class' => 'input text left'
		    )
		));
		echo $this->Form->input('start_minute', array(
		    'options' => $minutes,
		    'empty' => 'Minute',
		    'label' => ' ',
		    'div' => array(
		    	'class' => 'input text right'
		    )
		));
		echo '<div class="clear"></div>';
		echo $this->Form->input('end_hour', array(
		    'options' => $hours,
		    'empty' => 'Hour',
		    'label' => 'End Time',
		    'div' => array(
		    	'class' => 'input text left'
		    )
		));
		echo $this->Form->input('end_minute', array(
		    'options' => $minutes,
		    'empty' => 'Minute',
		    'label' => ' ',
		    'div' => array(
		    	'class' => 'input text right'
		    )
		));
		echo '<div class="clear"></div>';
		echo $this->Form->button('Add Schedule', array('type' => 'submit', 'class' => 'right', 'id' => 'add-schedule'));
		echo '<div class="clear"></div>';
		echo $this->Form->end();
	?>
	</div>
</div>