function WeeklySchedule()
{
	this.currentDate = new Date();

	this.SetupScheduleDate();
}

WeeklySchedule.prototype.SetupScheduleDate = function()
{
	$('#topbar #date').html(months[this.currentDate.getMonth()] + "<span id='year'> " + this.currentDate.getFullYear() + '</span>');

	alert(this.GetDayOfWeek(new Date(), 5, 1));
}

// dayOfWeek (1-7) 1 = Monday, 7 = Sunday
WeeklySchedule.prototype.GetDayOfWeek = function(date, dayOfWeek, weekOffset)
{
	var day = date.getDay();
	var difference = (date.getDate() - day + (day == 0 ? -6 : 0)) + dayOfWeek + (7 * weekOffset);
	
	return new Date(date.setDate(difference));
}