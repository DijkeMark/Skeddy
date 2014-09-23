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
			self.AddToSchedule();
		}
	});

	this.ResetDragHandlers();
}

Scheduler.prototype.ResetDragHandlers = function()
{
	var self = this;

	$('#sidebar .team-member').draggable(
	{
		revert:true,
		disabled:true,
		stop:function(event, ui)
		{
			$(ui.helper).addClass('selected');

			self.ResetDragHandlers();
		}
	});

	$('#sidebar .team-member.selected').draggable(
	{
		disabled:false
	});
}

Scheduler.prototype.AddToSchedule = function()
{
	alert('adding');
}