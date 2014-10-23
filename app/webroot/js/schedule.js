var days = new Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$(document).ready(function()
{
	var scheduler = new Scheduler();
	scheduler.CreateNewSchedule('weekly');
});

function Scheduler()
{
	this.schedule;
	this.sidebarCalendar = new SidebarCalendar();

	this.SetupClickHandlers();
	this.SetupDragAndDropHandlers();
}

Scheduler.prototype.CreateNewSchedule = function(type)
{
	switch(type)
	{
		case 'weekly':
			this.schedule = new WeeklySchedule();
			break;
	}

	this.sidebarCalendar.SetSchedule(this.schedule);
	this.schedule.SetSidebar(this.sidebarCalendar);
	this.schedule.GetScheduleItems();
}

Scheduler.prototype.SetupClickHandlers = function()
{
	var self = this;

	$('#topbar #navigation #previous').on('click', function()
	{
		self.schedule.Previous();
	});

	$('#topbar #navigation #next').on('click', function()
	{
		self.schedule.Next();
	});

	$('#topbar #navigation #today').on('click', function()
	{
		self.schedule.Today();
	});

	$('#l-sb-btn').on('click', function()
	{
		$('#c-l-sb').removeClass('collapsed');
	});

	$('#r-sb-btn').on('click', function()
	{
		$('#tm-r-sb').removeClass('collapsed');
	});

	$('.sidebar #top #close').on('click', function()
	{
		$(this).parent().parent().addClass('collapsed');
	});

	$('#tm-r-sb .team-member').on('click', function()
	{
		var hasClass = $(this).hasClass('selected');

		$('#tm-r-sb .team-member').removeClass('selected');
		if(!hasClass)
		{
			$(this).addClass('selected');
		}

		self.ResetDragHandlers();
	});

	$('#c-l-sb #calendar-navigation #next').on('click', function()
	{
		self.sidebarCalendar.Next();
	});

	$('#c-l-sb #calendar-navigation #previous').on('click', function()
	{
		self.sidebarCalendar.Previous();
	});
}

Scheduler.prototype.SetupDragAndDropHandlers = function()
{
	var self = this;
	
	$('#schedule .day').droppable(
	{
		drop:function(event, ui)
		{
			var employerId = $(ui.draggable).attr('id');
			var date = $(this).find('.day-indicator').attr('id');

			$('body').append('<div id="add-to-schedule"></div>');

			$('#add-to-schedule').load('/schedules/loadNewScheduleElement', function()
			{
				$('#new-schedule #close').on('click', function()
				{
					$('#add-to-schedule').remove();
				});
				$('#new-schedule #datepicker').datepicker();
				$('#new-schedule #datepicker').datepicker('option', 'dateFormat', 'yy-mm-dd');
				$('#new-schedule #datepicker').datepicker('setDate', date);

				$('#new-schedule #add-schedule').on('click', function(event)
				{
					event.preventDefault();

					form = $("#TimeScheduleItemLoadNewScheduleElementForm").serialize();
					self.schedule.AddToSchedule(employerId, form);
				});
			});
		}
	});

	this.ResetDragHandlers();
}

Scheduler.prototype.ResetDragHandlers = function()
{
	var self = this;

	$('#tm-r-sb .team-member').draggable(
	{
		revert:true,
		disabled:true,
		stop:function(event, ui)
		{
			$(ui.helper).addClass('selected');

			self.ResetDragHandlers();
		}
	});

	$('#tm-r-sb .team-member.selected').draggable(
	{
		disabled:false
	});
}

function SidebarCalendar()
{
	this.monthOffset = 0;
	this.schedule;

	this.SetupCalendar();
}

SidebarCalendar.prototype.SetupCalendar = function()
{		
	var date = new Date();
    date.setDate(1);
    date.setMonth(date.getMonth() + this.monthOffset);

    $('#calendar #calendar-navigation #month').html(months[date.getMonth()] + ' ' + date.getFullYear());

    day = date.getDay() - 1;
    if(day < 0)
    {
    	day = 6;
    }

    $('#calendar #days').empty();
    $('#calendar #week-numbers').empty();

    if(day == 0)
    {
    	var lastMonth = new Date();
    	lastMonth.setDate(1);
    	lastMonth.setMonth(lastMonth.getMonth() + this.monthOffset - 1);
    	daysInLastMonth = lastMonth.GetDaysInMonth(lastMonth.getMonth() + 1, lastMonth.getFullYear()) - 6;
    	lastMonth.setDate(daysInLastMonth);
    	weekNumber = lastMonth.GetWeekNumber();

	    for(var i = 0; i < 7; i++)
	    {
	    	$('#calendar #days').append('<div class="day left other-month">' + daysInLastMonth + '</div>');
	    	daysInLastMonth += 1;
	    }

	    $('#calendar #week-numbers').append('<div class="day legend">' + weekNumber + '</div>');
	}

	var lastMonth = new Date();
	lastMonth.setDate(1);
	lastMonth.setMonth(lastMonth.getMonth() + this.monthOffset - 1);
	daysInLastMonth = lastMonth.GetDaysInMonth(lastMonth.getMonth() + 1, lastMonth.getFullYear()) - (day - 1);

    for(var i = 0; i < day; i++)
    {
    	$('#calendar #days').append('<div class="day left other-month">' + daysInLastMonth + '</div>');
	    daysInLastMonth += 1;
    }

    var weekNumbers = Array();

    for(var i = 0; i < date.GetDaysInMonth(date.getMonth() + 1, date.getFullYear()); i++)
    {
    	date.setDate(i + 1);
    	weekNumber = date.GetWeekNumber();

    	if($.inArray(weekNumber, weekNumbers) == -1)
    	{
    		weekNumbers.push(weekNumber);

    		$('#calendar #week-numbers').append('<div class="day legend">' + weekNumber + '</div>');
    	}

    	day = i + 1;
    	if(day < 10)
    	{
    		day = '0' + day;
    	}

    	month = date.getMonth() + 1;
    	if(month < 10)
    	{
    		month = '0' + month;
    	}

    	$('#calendar #days').append('<div class="day left active" id="' + date.getFullYear() + '-' + month + '-' + day + '">' + (i + 1) + '</div>');
    }

    var maxDaysOnCalendar = 42;
    daysDifference = maxDaysOnCalendar - $('#calendar-container #days .day').length;

    var nextMonth = new Date();
	nextMonth.setDate(1);
	nextMonth.setMonth(nextMonth.getMonth() + this.monthOffset + 1);

    for(var i = 0; i < daysDifference; i++)
    {
    	nextMonth.setDate(i + 1);
    	$('#calendar #days').append('<div class="day left other-month">' + nextMonth.getDate() + '</div>');
    }

    if(daysDifference >= 7)
    {
    	$('#calendar #week-numbers').append('<div class="day legend">' + nextMonth.GetWeekNumber() + '</div>');
    }

    $('#calendar #days').append('<div class="clear"></div>');

    var self = this;
    $('.day.active').on('click', function()
	{
		var dateParts = $(this).attr('id').split('-');
		var clickedDate = new Date();
		clickedDate.setFullYear(dateParts[0]);
		clickedDate.setMonth(dateParts[1] - 1);
		clickedDate.setDate(dateParts[2]);
		clickedDate.setHours(0, 0, 0);

		self.schedule.GoToDate(clickedDate);
	});
}

SidebarCalendar.prototype.Next = function()
{
	this.monthOffset += 1;

	this.SetupCalendar();
	this.schedule.SetSidebarActives();
}

SidebarCalendar.prototype.Previous = function()
{
	this.monthOffset -= 1;

	this.SetupCalendar();
	this.schedule.SetSidebarActives();
}

SidebarCalendar.prototype.Today = function()
{
	this.monthOffset = 0;

	this.SetupCalendar();
	this.schedule.SetSidebarActives();
}

SidebarCalendar.prototype.SetSchedule = function(schedule)
{
	this.schedule = schedule;
}

Date.prototype.GetDaysInMonth = function(month, year)
{
    return new Date(year, month, 0).getDate();
}

Date.prototype.GetWeekNumber = function()
{
	var date = new Date(+this);
    date.setHours(0, 0, 0);
    date.setDate(date.getDate() + 4 - (date.getDay() || 7));
    return Math.ceil((((date - new Date(date.getFullYear(), 0, 1)) / 8.64e7) + 1 ) / 7);
}