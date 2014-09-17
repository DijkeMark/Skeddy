function WeeklySchedule()
{
	this.currentDate = new Date();
	this.weekOffset = 0;

	this.SetupScheduleDate();
}

WeeklySchedule.prototype.SetupScheduleDate = function()
{
	var monday = this.GetDayOfWeek(0, this.weekOffset);
	var tuesday = this.GetDayOfWeek(1, this.weekOffset);
	var wednesday = this.GetDayOfWeek(2, this.weekOffset);
	var thursday = this.GetDayOfWeek(3, this.weekOffset);
	var friday = this.GetDayOfWeek(4, this.weekOffset);
	var saturday = this.GetDayOfWeek(5, this.weekOffset);
	var sunday = this.GetDayOfWeek(6, this.weekOffset);
	
	$('#schedule .day#monday .day-indicator').html('Mon ' + monday.getDate());
	$('#schedule .day#tuesday .day-indicator').html('Tue ' + tuesday.getDate());
	$('#schedule .day#wednesday .day-indicator').html('Wed ' + wednesday.getDate());
	$('#schedule .day#thursday .day-indicator').html('Thu ' + thursday.getDate());
	$('#schedule .day#friday .day-indicator').html('Fri ' + friday.getDate());
	$('#schedule .day#saturday .day-indicator').html('Sat ' + saturday.getDate());
	$('#schedule .day#sunday .day-indicator').html('Sun ' + sunday.getDate());

	$('#topbar #date').html(months[this.currentDate.getMonth()] + "<span id='year'> " + this.currentDate.getFullYear() + '</span>');
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