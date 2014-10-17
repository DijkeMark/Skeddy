var days = new Array('Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun');
var months = new Array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');

$(document).ready(function()
{
	var scheduler = new Scheduler();
	scheduler.CreateNewSchedule('weekly');
});

function Scheduler()
{
	var schedule;

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
}

Scheduler.prototype.SetupDragAndDropHandlers = function()
{
	var self = this;
	
	$('.day').droppable(
	{
		drop:function(event, ui)
		{
			var employerId = $(ui.draggable).attr('id');
			var date = $(this).find('.day-indicator').attr('id');

			self.schedule.AddToSchedule(employerId, date);
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