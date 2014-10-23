function WeeklySchedule()
{
	this.weekOffset = 0;
	this.sidebarCalendar;

	this.SetupScheduleDate();
}

WeeklySchedule.prototype.SetupScheduleDate = function()
{
	var daysInWeek = new Array();
	var todayInWeek = false;
	for(var i = 0; i < 7; i++)
	{
		daysInWeek[i] = this.GetDayOfWeek(i, this.weekOffset);

		var month = daysInWeek[i].getMonth() + 1;
		if(month < 10)
		{
			month = '0' + month;
		}

		var day = daysInWeek[i].getDate();
		if(day < 10)
		{
			day = '0' + day;
		}

		$('#schedule .day#' + i + ' .day-indicator').html(days[i] + ' ' + daysInWeek[i].getDate());
		$('#schedule .day#' + i + ' .day-indicator').attr('id', daysInWeek[i].getFullYear() + '-' + month + '-' + day);

		var today = new Date();
		if(daysInWeek[i].getDate() == today.getDate()
			&& daysInWeek[i].getMonth() == today.getMonth()
			&& daysInWeek[i].getFullYear() == today.getFullYear())
		{
			$('#schedule .day#' + i + ' .day-indicator').addClass('today');
			todayInWeek = true;
		}
	}

	if(!todayInWeek)
	{
		$('#schedule .day .day-indicator').removeClass('today');
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

	this.SetSidebarActives();
}

WeeklySchedule.prototype.SetSidebarActives = function()
{
	$('#c-l-sb .day').removeClass('current');

	$('#schedule .day').each(function()
	{
		var id = $(this).find('.day-indicator').attr('id');
		$('#c-l-sb .day#' + id).addClass('current');
	});
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
	this.GetScheduleItems();
}

WeeklySchedule.prototype.Previous = function()
{
	this.weekOffset -= 1;

	this.SetupScheduleDate();
	this.GetScheduleItems();
}

WeeklySchedule.prototype.Today = function()
{
	this.weekOffset = 0;

	this.sidebarCalendar.Today();

	this.SetupScheduleDate();
	this.GetScheduleItems();
}

WeeklySchedule.prototype.GoToDate = function(date)
{
	var dateParts = $('#schedule .day#0 .day-indicator').attr('id').split('-');
	var firstDayOfWeek = new Date();
	firstDayOfWeek.setFullYear(dateParts[0]);
	firstDayOfWeek.setMonth(dateParts[1] - 1);
	firstDayOfWeek.setDate(dateParts[2]);
	firstDayOfWeek.setHours(0, 0, 0);

	scheduleWeekNumber = firstDayOfWeek.GetWeekNumber();
	dateWeekNumber = date.GetWeekNumber();

	this.weekOffset += (dateWeekNumber - scheduleWeekNumber);

	this.SetupScheduleDate();
	this.GetScheduleItems();
}

WeeklySchedule.prototype.SetSidebar = function(sidebarCalendar)
{
	this.sidebarCalendar = sidebarCalendar;
}

WeeklySchedule.prototype.AddToSchedule = function(employerId, form)
{
	var self = this;
	var startDayOfWeek = $('.day#0 .day-indicator').attr('id');
	var endDayOfWeek = $('.day#6 .day-indicator').attr('id');
	var scheduleType = 'weekly';
	
	$.ajax(
	{
		url:'/schedules/addNewItemToRoster',
		type:'post',
		dataType:'json',
		data:form + '&scheduleType=' + encodeURIComponent(scheduleType)
			+ '&employerId=' + encodeURIComponent(employerId)
			+ '&startDayOfWeek=' + encodeURIComponent(startDayOfWeek)
			+ '&endDayOfWeek=' + encodeURIComponent(endDayOfWeek),
		success:function(jsonData)
		{
			if(jsonData.ScheduleItems.length > 0)
			{
				self.FillSchedule(jsonData);
			}
		}
	});
}

WeeklySchedule.prototype.FillSchedule = function(jsonData)
{
	$('.day-schedule').empty();

	for(var i = 0; i < jsonData.ScheduleItems.length; i++)
	{
		var item = jsonData.ScheduleItems[i];
		var itemId = item['TimeScheduleItem']['id'];
		var name = item['TimeScheduleItem']['name'];
		var date = item['TimeScheduleItem']['date'];
		var profilePhoto = item['Employer'][0]['profile_photo'];
		var startHour = parseInt(item['TimeScheduleItem']['start_hour']);
		var startMinute = parseInt(item['TimeScheduleItem']['start_minute']);
		var endHour = parseInt(item['TimeScheduleItem']['end_hour']);
		var endMinute = parseInt(item['TimeScheduleItem']['end_minute']);

		var hourHeight = 40;
		var maxWidth = parseInt($('.day-schedule').css('width')) - 2;

		if($('.schedule-item#si' + itemId).length == 0)
		{
			var startPos = (startHour + (startMinute / 60)) * hourHeight;
			var itemHeight = ((endHour + (endMinute / 60)) * hourHeight) - startPos;
			$('.day .day-indicator#' + date).siblings('.day-schedule').append('<div class="schedule-item left" id="si' + itemId + '"></div>');
			$('.schedule-item#si' + itemId).css(
			{
				width:maxWidth,
				height:itemHeight,
				top:startPos
			});

			if(startHour == 0)
				startHour = '0' + startHour;

			if(startMinute == 0)
				startMinute = '0' + startMinute;

			if(endHour == 0)
				endHour = '0' + endHour;

			if(endMinute == 0)
				endMinute = '0' + endMinute;

			$('.schedule-item#si' + itemId).append('<div class="schedule-name">' + name + ' (' + startHour + ':' + startMinute + ' - ' + endHour + ':' + endMinute + ')</div>');
		}
	}
}

WeeklySchedule.prototype.GetScheduleItems = function()
{
	var self = this;
	var startDayOfWeek = $('.day#0 .day-indicator').attr('id');
	var endDayOfWeek = $('.day#6 .day-indicator').attr('id');
	var scheduleType = 'weekly';
	
	$.ajax(
	{
		url:'/schedules/getScheduleItems',
		type:'post',
		dataType:'json',
		data:{
			scheduleType:	scheduleType,
			startDayOfWeek:	startDayOfWeek,
			endDayOfWeek:	endDayOfWeek
		},
		dataType:"text",
		success:function(data)
		{
			var jsonData = $.parseJSON(data);
			if(jsonData.ScheduleItems.length > 0)
			{
				self.FillSchedule(jsonData);
			}
		}
	});
}