var schedule;
var days = new Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$(document).ready(function()
{
	SetupClickHandlers();
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
}