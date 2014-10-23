<!DOCTYPE html>
<html>
	<head>
		<title>Skeddy</title>
		<?php
			echo $this->html->css(array('schedule', '../font-awesome/css/font-awesome.min', '../js/jquery-ui/jquery-ui.min'));
			echo $this->html->script(array('jQuery', 'jquery-ui/jquery-ui.min', 'schedule', 'weeklySchedule'));

			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>

	<body>
		<?php
			echo $this->element('topbar');

			echo $this->Session->flash();

			echo $this->fetch('content');
		?>
	</body>
</html>
