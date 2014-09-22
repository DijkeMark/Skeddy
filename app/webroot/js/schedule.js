var schedule;
var days = new Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$(document).ready(function()
{
	SetupClickHandlers();
	SetupDragAndDropHandlers();

	CreateNewSchedule('weekly');
});

function CreateNewSchedule(type)
{
	switch(type)
	{
		case 'weekly':
			schedule = new WeeklySchedule();
			break;
	}
}

function SetupClickHandlers()
{
	$('#topbar #navigation #previous').on('click', function()
	{
		schedule.Previous();
	});

	$('#topbar #navigation #next').on('click', function()
	{
		schedule.Next();
	});

	$('#sidebar	#top #icon').on('click', function()
	{
		$('#sidebar').toggleClass('collapsed');
	});

	$('#sidebar	#top #close').on('click', function()
	{
		$('#sidebar').addClass('collapsed');
	});

	$('#sidebar .team-member').on('click', function()
	{
		var hasClass = $(this).hasClass('selected');

		$('#sidebar .team-member').removeClass('selected');
		if(!hasClass)
		{
			$(this).addClass('selected');
		}

		ResetDragHandlers();
	});
}

function SetupDragAndDropHandlers()
{
	$('.day').droppable(
	{
		drop:function(event, ui)
		{
			alert($(this).find('.day-indicator').text());
		}
	});

	ResetDragHandlers();
}

function ResetDragHandlers()
{
	$('#sidebar .team-member').draggable(
	{
		revert:true,
		disabled:true
	});

	$('#sidebar .team-member.selected').draggable(
	{
		disabled:false
	});
}