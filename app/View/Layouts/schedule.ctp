<!DOCTYPE html>
<html>
	<head>
		<title>Skeddy</title>
		<?php
			echo $this->html->css('schedule');
			echo $this->html->css('../font-awesome/css/font-awesome.min');

			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>

	<body>
		<div id='topbar'>
			<div id='navigation'>
				<div id='previous' class='left'>
					<i class="fa fa-angle-left"></i>
				</div>
				<div id='next' class='left'>
					<i class="fa fa-angle-right"></i>
				</div>
			</div>

			<div id='date'>
				Month <span id='year'>Year</span>
			</div>
		</div>

		<?php
			echo $this->Session->flash();

			echo $this->fetch('content');
		?>
	</body>
</html>
