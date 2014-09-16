<!DOCTYPE html>
<html>
	<head>
		<title>Skeddy</title>
		<?php
			echo $this->html->css('login');

			echo $this->fetch('css');
			echo $this->fetch('script');
		?>
	</head>

	<body>
		<?php
			echo $this->Session->flash();

			echo $this->fetch('content');
		?>
	</body>
</html>
