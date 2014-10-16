<?php
if(isset($teamMembers))
{
?>
<div id='right-sidebar' class='sidebar collapsed'>
	<div id='top'>
		<div id='close'>
			<i class="fa fa-times"></i>
		</div>
		<div id='title'>Team members</div>
	</div>
	<div id='team-members'>
	<?php
	for($i = 0; $i < count($teamMembers); $i++)
	{
	?>
		<div class='team-member' id='<?php echo $teamMembers[$i]['Employer']['id']; ?>'>
			<div class='profile-icon left'>
				<?php echo $this->Html->image($teamMembers[$i]['Employer']['profile_photo'], array('alt' => '', 'class' => 'profile-photo')); ?>
			</div>
			<div class='info'>
				<div class='name'>
					<?php echo $teamMembers[$i]['Employer']['name'].' '.$teamMembers[$i]['Employer']['insertion'].' '.$teamMembers[$i]['Employer']['lastname']; ?>
				</div>
				<div class='job-name'>
					<?php echo $teamMembers[$i]['Job']['name']; ?>
				</div>
			</div>
			<div class='clear'></div>
		</div>
	<?php
	}
	?>
	</div>
</div>
<?php
}
?>