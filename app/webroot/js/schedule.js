var schedule;
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$(document).ready(function()
{
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