function WeeklySchedule()
{
	this.currentDate = new Date();
	this.weekOffset = 0;

	this.SetupScheduleDate();
}

WeeklySchedule.prototype.SetupScheduleDate = function()
{
	var daysInWeek = new Array();
	for(var i = 0; i < 7; i++)
	{
		daysInWeek[i] = this.GetDayOfWeek(i, this.weekOffset);
		$('#schedule .day#' + i + ' .day-indicator').html(days[i] + ' ' + daysInWeek[i].getDate());
	}

	var year = daysInWeek[0].getFullYear();
	var month = months[daysInWeek[0].getMonth()];
	var monthYear = month + ' <span id="year">' + year + '</span>';

	if(daysInWeek[0].getMonth() != daysInWeek[6].getMonth())
	{
		if(daysInWeek[0].getFullYear() != daysInWeek[6].getFullYear())
		{
			monthYear = months[daysInWeek[0].getMonth()] + ' <span id="year">' + daysInWeek[0].getFullYear() + '</span>'
						+ ' / ' + months[daysInWeek[6].getMonth()] + ' <span id="year">' + daysInWeek[6].getFullYear() + '</span>';
		}
		else
		{
			monthYear = months[daysInWeek[0].getMonth()] + ' / ' + months[daysInWeek[6].getMonth()] + ' <span id="year">' + year + '</span>';
		}
	}

	$('#topbar #date').html(monthYear);
}

WeeklySchedule.prototype.GetDayOfWeek = function(dayOfWeek, weekOffset)
{
	var date = new Date();
	var day = date.getDay();
	var difference = ((date.getDate() + (7 * weekOffset)) - day + (day == 0 ? -6 : 1)) + dayOfWeek;
	
	return new Date(date.setDate(difference));
}

WeeklySchedule.prototype.Next = function()
{
	this.weekOffset += 1;

	this.SetupScheduleDate();
}

WeeklySchedule.prototype.Previous = function()
{
	this.weekOffset -= 1;

	this.SetupScheduleDate();
}