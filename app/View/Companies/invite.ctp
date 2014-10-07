<?php
	$this->html->script(array('companies'), array('inline' => false));
?>
<div id='settings-container'>
	<h1>Invitations</h1>
	<?php
		echo $this->Form->create(null, array('url' => array('controller' => 'companies', 'action' => 'invite')));
		echo $this->Form->input('email');
		echo $this->Form->hidden('company_id', array('value' => $companyId));
		echo $this->Form->submit('Send Invite', array('id' => 'send-invite'));
		echo $this->Form->end();
	?>

	<div id='error'></div>
	<div id='pending-invitations'>
		<?php
		for($i = 0; $i < count($invitedEmployers); $i++)
		{
			$employer = $invitedEmployers[$i]['InvitedEmployer'];
			$id = $employer['id'];
			$email = $employer['email'];
		?>
			<div class="invited-employer" id="<?php echo $id; ?>">
				<div class="email left"><?php echo $email; ?></div>
				<div class="cancel right">Cancel</div>
				<div class="clear"></div>
			</div>
		<?php
		}
		?>
	</div>
</div>